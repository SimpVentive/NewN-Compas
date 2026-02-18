/*DataTable Init*/

"use strict"; 

$(document).ready(function() {
	"use strict";
	
	$('#datable_1').DataTable({"aaSorting": [  [2,'desc'], [6,'desc'], [0,'asc'] ]});
    $('#datable_2').DataTable({ "lengthChange": false});
} );