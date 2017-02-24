<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Autoservis | Pocetna</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.11.2.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
        <script type="text/javascript">
            var map;
            
            function initialize() {

                var latLng = new google.maps.LatLng(44.7945124, 20.4794992);

                var mapOptions = { zoom: 12, scrollwheel: false, center: latLng };

                map = new google.maps.Map(
                    document.getElementById('map'), mapOptions);

                var marker = new google.maps.Marker({
                    position: latLng, map: map
                });
            }

            google.maps.event.addDomListener(window, 'load', initialize);

            $.get( "controller.php", { podaci: "tipovi"} )
                .done( function( data ) {

                    var tipovi = ''; var podaci = JSON.parse(data);

                    for (var i = 0; i < podaci.length; i++) {

                        tipovi += '<option value="'+podaci[i].id+'">'+
                            podaci[i].naziv+'</option>';
                    };

                    $('#tip').html(tipovi);
            });

            $.get( "controller.php", { podaci: "marke"} )
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

                $.get('controller.php', { podaci: 'artikli', model: $('#termin').val()})
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

									'<button class="btn btn-primary" onclick="poruci('+podaci[i].id+')">Poruci</button>'+
									
								'</div>'+
							'</div>';
                            };

                        $('#artikli').html(artikli);
                });
            }  

            function sortiraj () {

                $.get('controller.php', { podaci: 'artikli', marka: $('#marke').val()})
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

									'<button class="btn btn-primary" onclick="poruci('+podaci[i].id+')">Poruci</button>'+
									
								'</div>'+
							'</div>';
                            };

                        $('#artikli').html(artikli);
                });
            }

            function poruci (idArt) {

                $('#artikl').val(idArt);
                $('#kupon').modal('toggle');
            }
        </script>
	</head>
	<body>

		<!-- Modal -->
		<div class="modal fade" id="kupon" tabindex="-1" role="dialog" aria-hidden="true">
		  	<div class="modal-dialog" style="margin-top:10%;  width: 400px">
			    <div class="modal-content">
			      	<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h3 class="modal-title" id="myModalLabel">Vas kupon</h3>
			      	</div>

			      	<form action="controller.php" method="POST">

			      		<input type="hidden" name="podaci" value="kupon">
                        <input id="artikl" type="hidden" name="artikl" value=""/>

				      	<div class="modal-body">
				        	<div class="form-group">
                                <input type="text" name="ime" class="form-control" placeholder="Ime Prezime" required>
                            </div>
				        	<div class="form-group">
				        		<div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="text" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="text" name="telefon" class="form-control" placeholder="Telefon" required>
                                    </div>
                                </div>
				        	</div>
				        	<div class="form-group">
								<textarea rows="3" class="form-control" name="adresa" placeholder="Adresa" required></textarea>
							</div>
				      	</div>
				      	<div class="modal-footer">
					        <button type="reset" class="btn btn-default" data-dismiss="modal">Zatvori</button>
					        <button type="submit" class="btn btn-primary">Poruci</button>
				      	</div>
			      	</form>
			    </div>
		  	</div>
		</div>

		
		<div id="slider" class="carousel slide" data-ride="carousel">
			    <ol class="carousel-indicators">
			        <li data-target="#slider" data-slide-to="0" class=""></li>
			        <li data-target="#slider" data-slide-to="1" class=""></li>
			        <li data-target="#slider" data-slide-to="2" class="active"></li>
			    </ol>
			    <div class="carousel-inner">
			        <div class="item">
			            <img src="img/1.jpg" style="height: 500px; margin-left:30%">
			        </div>
			        <div class="item">
			            <img src="img/2.jpg" style="height: 500px; margin-left:30%">
			        </div>
			        <div class="item active">
			            <img src="img/3.jpg" style="height: 500px; margin-left:30%">
			        </div>
			    </div>
			    <a class="left carousel-control" href="#slider" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
			    <a class="right carousel-control" href="#slider" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
		</div>
		

		<div class="jumbotron">
			<div class="container">
				<h1>Autoservis</h1>
				<p>Mesto na kome mozete naci sve za vaseg ljubimca, od farova, preko brisaca, pa sve do lezajeva i auto kozmetike... ;)</p>
				
				<div class="row">
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="input-group">
                            <input id="termin" type="text" class="form-control" placeholder="Pretraga artikala..." style="height: 45px">
                            <span class="input-group-btn" >
                                <button class="btn btn-primary" type="button" onclick="pretrazi()" style="height: 45px">
                                <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <select class="form-control" id="marke" onchange="sortiraj()" style="height: 45px"></select>
                    </div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row"  id="artikli">
					<?php require 'config.php';

					include 'models/Model.php';
					include 'models/Artikl.php';
					include 'models/Kupon.php';
					include 'models/Marka.php';
					include 'models/Tip.php';

					$konekcija = new MySqli($mysql_server, $mysql_user, 
						$mysql_password, $mysql_db);

					error_reporting(0); # gasimo upozorenja
					$artikl = new Artikl($konekcija);

					foreach ($artikl->getAll() as $deo): ?>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="artikl<?= $deo->id ?>">
							<div class="well">
								<legend><?= $deo->naziv ?> (<?= $deo->model ?>)</legend>

								<p><b>Opis: </b> <?= $deo->opis ?></p>

								<div class="row">
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<p><b>Tip: </b> <?= $deo->tip->naziv ?></p>
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<p><b>Marka: </b><?= $deo->marka->naziv ?></p>
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<p><b>Cena: </b><?= $deo->cena ?> RSD</p>
									</div>
								</div><br>

								<button class="btn btn-primary" onclick="poruci(<?= $deo->id ?>)">Poruci</button>
								
							</div>
						</div>
					<?php endforeach ?>	
			</div>
		</div>

		<div id="map" style="height: 500px"></div>
	</body>
</html>