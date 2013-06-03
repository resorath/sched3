$(document).ready(function(){

	// autofocus
	$("input:text:visible:first").focus();

	// Spinning Gear
	$('#settings-cog-button').hover(
		function() { $('#settings-cog').addClass('icon-spin') },
		function() { $('#settings-cog').removeClass('icon-spin') }
	);

	$('a').click(function(){
		setTimeout(function() {
			$('#loading_box').show();
		}, 1500);
	});

});