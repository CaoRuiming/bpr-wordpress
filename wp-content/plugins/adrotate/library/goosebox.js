/*--------------------------------------//
 Popups that work
 Version: 1.0.1
 Original code: Arnan de Gans
 Copyright: (c) 2020 Arnan de Gans
//--------------------------------------//
 Changelog:
//--------------------------------------//
 7 sept 2020
 * Adjusted top margin
//--------------------------------------*/
jQuery(document).ready(function($) {
	$('.goosebox').click(function() {
		var left = (screen.width/2)-375;
		var top = (screen.height/2)-175;
		var NWin = window.open($(this).prop('href'), 'Spread the word', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=no, resizable=yes, copyhistory=no, width=750, height=550, top='+top+', left='+left);
		if (window.focus) { NWin.focus(); }
		return false;
	});
});