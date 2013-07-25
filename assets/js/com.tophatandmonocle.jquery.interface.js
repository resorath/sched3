$(document).ready(function(){

	// autofocus
	$("input:text:visible:first").focus();

	// Spinning Gear
	$('#settings-cog-button').hover(
		function() { $('#settings-cog').addClass('icon-spin') },
		function() { $('#settings-cog').removeClass('icon-spin') }
	);

	$('a:not([href^="#"])').click(function(){
		setTimeout(function() {
			$('#loading_box').show();
		}, 1500);
	});

	fillImage(".imgfiller");

	function fillImage(filldiv)
	{
	   div = $(filldiv);
	   imgsrc = div.find('img').attr('src');

	   var img = new Image()
	   img.onload = function(){
	        imgw = img.width;
	        imgh = img.height;

	        //after its loaded and you got the size..
	        //you need to call it the first time of course here and make it visible:

	        resizeMyImg(imgw,imgh);
	        div.find('img').show();

	        //now you can use your resize function
	        $(window).resize(function(){ resizeMyImg(imgw,imgh) });

	        }
	   img.src = imgsrc


	   function resizeMyImg(w,h)
	   {     
	      //the width is larger
	      if (w > h) {
	        //resize the image to the div
	        div.find('img').width(div.innerWidth() + 'px').height('auto');
	      }        
	      else {
	        // the height is larger or the same
	        //resize the image to the div
	        div.find('img').height(div.innerHeight() + 'px').width('auto');
	      }

	    }
	}

});

// blinking elements
var idArray = [];
var defaultColor = '#000000';

function toggleColor(id, color) {
    var e = $(id);
    var currentColor = $(id).css('color');
    if (currentColor == defaultColor) {
      $(id).css('color', color);
    }
    else {
      $(id).css('color', defaultColor);
    }
}

function stopBlinking(id) {
    clearInterval(idArray[id]);
    $(id).css('color', defaultColor);
}

function blinkForTime(id, blinkTime, blinkColor) {
	defaultColor = $(id).css('color');
    idArray[id] = setInterval(function() {toggleColor(id, blinkColor)}, 200);
    setTimeout(function() {stopBlinking(id)}, blinkTime);
}
// /blinking elements