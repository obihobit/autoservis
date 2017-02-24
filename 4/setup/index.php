<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Autoservis | Admin</title>

        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-1.11.2.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1.1", {packages:["bar"]});
            google.setOnLoadCallback(drawStuff);

            var statistika = []; 

            $.get( "../service?type=stats",  
                function( result ) {
                    if (typeof(result) != 'undefined')
                        statistika = JSON.parse(result); 
                    else alert(result);  
            });

            function drawStuff() {
                var data = new google.visualization.arrayToDataTable(statistika);

                var options = {
                      width: 900, height: 500,
                      chart: {
                        title: 'Isplativost asortimana',
                        subtitle: 'odnos broja prodatih artikala i njihovih cena'
                    },
                      series: {
                        0: { axis: 'artikli' }, // Bind series 0 to an axis named 'artikli'.
                        1: { axis: 'cene' } // Bind series 1 to an axis named 'cene'.
                    },
                      axes: {
                        y: {
                          karte: {label: 'broj artikala'}, // Left y-axis.
                          cene: {side: 'right', label: 'raspon cena'} // Right y-axis.
                        }
                    }
                };

                var chart = new google.charts.Bar(document.getElementById('chart'));
                chart.draw(data, options);
            };

            $.get( "../controller.php", { podaci: "tipovi"} )
                .done( function( data ) {

                    var tipovi = ''; var podaci = JSON.parse(data);

                    for (var i = 0; i < podaci.length; i++) {

                        tipovi += '<option value="'+podaci[i].id+'">'+
                            podaci[i].naziv+'</option>';
                    };

                    $('#tip').html(tipovi);
            });

            $.get( "../controller.php", { podaci: "marke"} )
                .done( function( data ) {

                    var marke = ''; var podaci = JSON.parse(data);

                    for (var i = 0; i < podaci.length; i++) {

                        marke += '<option value="'+podaci[i].id+'">'+
                            podaci[i].naziv+'</option>';
                    };

                    $('#marke').html(marke);
                    $('#marka').html(marke);
            });  

            function pretrazi () {

                $.get('../controller.php', { podaci: 'artikli', model: $('#termin').val()})
                    .done(function( data ) {
                        var artikli = ''; var podaci = JSON.parse(data);

                        for (var i = 0; i < podaci.length; i++) {
                            artikli += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="artikl'+podaci[i].id+'">'+
								'<div class="well">'+
									'<legend>'+podaci[i].naziv+' ('+podaci[i].model+')</legend>'+

									'<div class="row">'+
										'<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+
											'<h4>'+podaci[i].cena+' RSD</h4>'+
										'</div>'+
										'<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+
											'<h4>'+podaci[i].stanje+' KOM</h4>'+
										'</div>'+
									'</div>'+

									'<div class="row">'+
										'<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+
											'<p><b>Tip: </b> '+podaci[i].tip.naziv+'</p>'+
										'</div>'+
										'<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+
											'<p><b>Marka: </b>'+podaci[i].marka.naziv+'</p>'+
										'</div>'+
									'</div><br>'+

									'<button class="btn btn-primary" onclick="izmeni('+podaci[i].id+')">Izmeni</button>&nbsp;'+
									'<button class="btn btn-danger" onclick="ukloni('+podaci[i].id+')">Ukloni</button>'+
									
								'</div>'+
							'</div>';
                            };

                        $('#artikli').html(artikli);
                });
            }  

            function sortiraj () {

                $.get('../controller.php', { podaci: 'artikli', marka: $('#marke').val()})
                    .done(function( data ) {
                        var artikli = ''; var podaci = JSON.parse(data);

                        for (var i = 0; i < podaci.length; i++) {
                            artikli += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="artikl'+podaci[i].id+'">'+
								'<div class="well">'+
									'<legend>'+podaci[i].naziv+' ('+podaci[i].model+')</legend>'+

									'<div class="row">'+
										'<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+
											'<h4>'+podaci[i].cena+' RSD</h4>'+
										'</div>'+
										'<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+
											'<h4>'+podaci[i].stanje+' KOM</h4>'+
										'</div>'+
									'</div>'+

									'<div class="row">'+
										'<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+
											'<p><b>Tip: </b> '+podaci[i].tip.naziv+'</p>'+
										'</div>'+
										'<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+
											'<p><b>Marka: </b>'+podaci[i].marka.naziv+'</p>'+
										'</div>'+
									'</div><br>'+

									'<button class="btn btn-primary" onclick="izmeni('+podaci[i].id+')">Izmeni</button>&nbsp;'+
									'<button class="btn btn-danger" onclick="ukloni('+podaci[i].id+')">Ukloni</button>'+
									
								'</div>'+
							'</div>';
                            };

                        $('#artikli').html(artikli);
                });
            }

            function izmeni (idArt) {
                $.get( '../controller.php', 
                    { podaci: 'artikli', kljuc: idArt })
                    .done(function( result ) {
                        var data = JSON.parse(result);

                        if (typeof data != 'undefined') {
                            $('#naziv').val(data.naziv);
                            $('#model').val(data.model);
                            $('#tip option[value='+data.tip.id+']')
                                .attr('selected', 'selected');
                            $('#marka option[value='+data.marka.id+']')
                                .attr('selected', 'selected');
                            $('#stanje').val(data.stanje);
                            $('#opis').val(data.opis);
                            $('#cena').val(data.cena);

                            $('#artId').val(data.id);
                            $('#akcija').val('izmeni');

                            $('#artikl').modal('toggle');
                        } else {
                            alert(result);
                        }
                    });
            }

            function ukloni (artId) {
                $.post( '../controller.php', { podaci: 'artikl', 
                	akcija: 'ukloni', kljuc: artId })
                .done(function( data ) {
                    if (data == 'OK') {
                        $('#artikl'+artId).remove();
                    } else {
                        alert('Greska pri brisanju iz baze!');
                    }
                });
            }
        </script>
	</head>
	<body>

		<!-- Modal -->
		<div class="modal fade" id="artikl" tabindex="-1" role="dialog" aria-hidden="true">
		  	<div class="modal-dialog" style="margin-top:10%;  width: 400px">
			    <div class="modal-content">
			      	<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h3 class="modal-title" id="myModalLabel">Unos dela</h3>
			      	</div>

			      	<form action="../controller.php" method="POST">

			      		<input type="hidden" name="podaci" value="artikl">
                        <input id="artId" type="hidden" name="artId" value=""/>
                        <input id="akcija" type="hidden" name="akcija" value=""/>

				      	<div class="modal-body">
				        	<div class="form-group">
				        		<div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="text" id="naziv" name="naziv" class="form-control" placeholder="Naziv" required>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="text" id="model" name="model" class="form-control" placeholder="Model" required>
                                    </div>
                                </div>
				        	</div>
				        	<div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <select class="form-control" name="tip" id="tip"></select>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <select class="form-control" name="marka" id="marka"></select>
                                    </div>
                                </div>
                            </div>
				        	<div class="form-group">
								<textarea rows="3" class="form-control" id="opis" name="opis" placeholder="Opis dela" required></textarea>
							</div>
				        	<div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="number" class="form-control" id="cena" name="cena" placeholder="Cena" required>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="number" class="form-control" id="stanje" name="stanje" placeholder="Stanje" required>
                                    </div>
                                </div>
                            </div>
				      	</div>
				      	<div class="modal-footer">
					        <button type="reset" class="btn btn-default" data-dismiss="modal">Zatvori</button>
					        <button type="submit" class="btn btn-primary">Zapamti</button>
				      	</div>
			      	</form>
			    </div>
		  	</div>
		</div>

		<div class="jumbotron">
			<div class="container">
				
				<h1>Autoservis adminpanel</h1>
				<p>Ovde mozete da manipulisete sadrzajem i podacim na vasem web shop-u... 
					Dodajte nove tipove artikala, marka i nove artikle</p>
				<div class="row">
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <div class="input-group">
                            <input id="termin" type="text" class="form-control" placeholder="Pretraga artikala..." style="height: 45px">
                            <span class="input-group-btn" >
                                <button class="btn btn-primary" type="button" onclick="pretrazi()" style="height: 45px">
                                <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <select class="form-control" id="marke" onchange="sortiraj()" style="height: 45px"></select>
                    </div>

					<a href="#artikl" data-toggle="modal" class="btn btn-danger btn-lg">Dodaj deo</a>
				</div>
			</div>
		</div>

		<div class="container">
			<div id="chart" style="margin-bottom:50px"></div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" id="artikli">

					<div class="row">
					<?php require '../config.php';

					include '../models/Model.php';
					include '../models/Artikl.php';
					include '../models/Kupon.php';
					include '../models/Marka.php';
					include '../models/Tip.php';

					$konekcija = new MySqli($mysql_server, $mysql_user, 
						$mysql_password, $mysql_db);

					error_reporting(0); # gasimo upozorenja
					$artikl = new Artikl($konekcija);
						foreach ($artikl->getAll() as $deo): ?>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="artikl<?= $deo->id ?>">
							<div class="well">
								<legend><?= $deo->naziv ?> (<?= $deo->model ?>)</legend>

								<div class="row">
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<h4><?= $deo->cena ?> RSD</h4>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<h4><?= $deo->stanje ?> KOM</h4>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<p><b>Tip: </b> <?= $deo->tip->naziv ?></p>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<p><b>Marka: </b><?= $deo->marka->naziv ?></p>
									</div>
								</div><br>

								<button class="btn btn-primary" onclick="izmeni(<?= $deo->id ?>)">Izmeni</button>
								<button class="btn btn-danger" onclick="ukloni(<?= $deo->id ?>)">Ukloni</button>
								
							</div>
						</div>
					<?php endforeach ?>	
					</div>
				</div>

				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="well">

						<form action="../controller.php" method="POST" role="form">
							<legend>Unos tipa</legend>

							<input type="hidden" name="podaci" value="tip">
						
							<div class="form-group">
								<input type="text" class="form-control" name="naziv" placeholder="Naziv" required>
							</div>
							<div class="form-group">
								<textarea rows="3" class="form-control" name="opis" placeholder="Opis tipa" required></textarea>
							</div>
						
							<button type="submit" class="btn btn-primary">Zapamti</button>
						</form>
					</div>

					<div class="well">
						<form action="../controller.php" method="POST" role="form">
							<legend>Unos marke</legend>

							<input type="hidden" name="podaci" value="marka">
						
							<div class="form-group">
								<input type="text" class="form-control" name="naziv" placeholder="Naziv" required>
							</div>
							<div class="form-group">
								<textarea rows="3" class="form-control" name="opis" placeholder="Opis marke" required></textarea>
							</div>
						
							<button type="submit" class="btn btn-primary">Zapamti</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>