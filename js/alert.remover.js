/*!
*	Alert remover for bootstrap
*	Copyright MeClaud 2017. All rights reserved.
*	
*	To use this library you need jQuery
*	Just add the class auto-remove to a alert and it will be removed
*/
$(document).ready(function (){
	// How much time the alert stays on screen in miliseconds
	var wait_time = 2000;

	$(".auto-remove").fadeTo(wait_time, 500).slideUp(500, function(){
		$(".auto-remove").slideUp(500);
	});
});