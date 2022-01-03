/*
Datepicker for exports and graphs
Version: 0.3
Original code: Arnan de Gans
Copyright: (c) 2020 Arnan de Gans
*/
(function($) {
	$(document).ready(function() {
		$('#startdate_picker').datepicker({dateFormat: 'dd-mm-yy'}); 
		$('#enddate_picker').datepicker({dateFormat: 'dd-mm-yy'}); 
	});
}(jQuery));
