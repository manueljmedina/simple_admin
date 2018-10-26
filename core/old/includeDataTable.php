<?php 

$datatable = '
<link rel="stylesheet" href="assets/plugins/datatables/media/css/dataTables.bootstrap.min.css">
<script src="assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/media/js/dataTables.bootstrap.min.js"></script>


<link rel="stylesheet" href="assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css">
<script src="assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/jszip.min.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/pdfmake.min.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/vfs_fonts.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js"></script>

<script>
$(document).ready( function() {
    $("#tableResultado").dataTable( {
	dom:		"Bfrtip",
	"order": [[ 0, "asc" ]],
	"aaSorting": [],
	"aLengthMenu": [15],
		buttons: [
            {
                extend: "copyHtml5",
                exportOptions: {
                    columns: [ 0, ":visible" ]
                }
            },  {
                extend: "print",
				 orientation: "landscape",
                exportOptions: {
                    columns: [ 0, ":visible" ]
                }
            },
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: ":visible"
                }
            }, "colvis",
           
        ],
		"language": {
            "paginate": {
                "first": "Primera p&aacute;gina",
                "next":"Siguiente",
                "previous":"Anterior" 
	    }
	}
          
	} );
} );

</script>

 ';
?>
