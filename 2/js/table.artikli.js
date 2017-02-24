
/*
 * Editor client script for DB table artikli
 * Automatically generated by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {

	var editor = new $.fn.dataTable.Editor( {
		"ajax": "php/table.artikli.php",
		"table": "#artikli",
		"fields": [
			{
				"label": "Tip",
				"name": "artikli.tip",
				"type": "text"
			},
			{
				"label": "Marka",
				"name": "artikli.marka",
				"type": "text"
			},
			{
				"label": "Naziv",
				"name": "artikli.naziv",
				"type": "text"
			},
			{
				"label": "Opis",
				"name": "artikli.opis",
				"type": "textarea"
			},
			{
				"label": "Cena",
				"name": "artikli.cena",
				"type": "text"
			},
			{
				"label": "Stanje",
				"name": "artikli.stanje",
				"type": "text"
			}
		]
	} );

    // Setup - add a text input to each footer cell
    $('#artikli tfoot th').each( function () {

        var title = $('#artikli thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Pretraga '+title+'" />' );
    } );
 
    // Activate the bubble editor on click of a table cell
    $('#artikli').on( 'click', 
    	'tbody td:not(:first-child)', function (e) {
	        editor.bubble( this );   
	    } );

	var table = $('#artikli').DataTable( {
		dom: 'Tfrtip',
		ajax: "php/table.artikli.php",
		/*language: { "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Serbian.json"
        }, JEZIK JE ISKLJUCEN JER ONDA NE RADI PRETRAGA PO KOLONAMA!!! */ 
		columns: [
			{
				"data": "tipovi.naziv"
			},
			{
				"data": "marke.naziv"
			},
			{
				"data": "artikli.naziv"
			},
			{
				"data": "artikli.opis"
			},
			{
				"data": "artikli.cena"
			},
			{
				"data": "artikli.stanje"
			}
		],
        order: [ 1, 'asc' ],
		tableTools: {
			sRowSelect: "os",
	        sRowSelector: 'td:first-child',
		    sSwfPath: "http://cdn.datatables.net/tabletools/2.2.3/swf/copy_csv_xls_pdf.swf",

			aButtons: [
				{ "sExtends": "editor_create", 
		            sButtonText: "Kreiraj",
					"editor": editor 
				},

				{ "sExtends": "editor_edit", 
		            sButtonText: "Izmeni",  
					"editor": editor 
				},

				{ "sExtends": "editor_remove", 
		            sButtonText: "Obrisi", 
					"editor": editor 
				},

		        {
		            sExtends: "collection",
		            sButtonText: "Sacuvaj",
		            sButtonClass: "save-collection",
		            aButtons: [ 'copy', 'csv', 'xls', 'pdf' ]
		        },
		        

				{ "sExtends": "print", 
		            sButtonText: "Stampaj" 
				}
			]
		}
	} );
 
    // Apply the search
    table.columns().eq( 0 ).each( function ( colIdx ) {

        $( 'input', table.column( colIdx ).footer() )
        .on( 'keyup change', function () {
    		console.log('Zapoceo pretragu!');
            table.column( colIdx ).search( this.value ).draw();
        } );
    } );

} );

}(jQuery));

