var parallax_elements = new Array();
var parallax_Xscales = new Array();
var parallax_Yscales = new Array();
var parallax_Xorigins = new Array();
var parallax_Yorigins = new Array();
var parallax_heights = new Array();
var parallax_widths = new Array();

var parallax_elements_bg = new Array();
var parallax_scales_bg = new Array();
var parallax_offsets_bg = new Array();

function parallax(element, Xscale, Yscale, Xorigin, Yorigin, height, width) {
	element.style.position = "relative";
	parallax_Xscales[parallax_elements.length] = Xscale - 1;
	parallax_Yscales[parallax_elements.length] = Yscale - 1;
	parallax_Xorigins[parallax_elements.length] = (Xorigin == undefined ? $(element).offset().left : Xorigin);
	parallax_Yorigins[parallax_elements.length] = (Yorigin == undefined ? $(element).offset().top : Yorigin);
	parallax_heights[parallax_elements.length] = (height == undefined ? $(element).height() : height) / 2;
	parallax_widths[parallax_elements.length] = (width == undefined ? $(element).width() : width) / 2;
	parallax_elements[parallax_elements.length] = element;
}
function backgroundParallax(element, scale, offset) {
	parallax_scales_bg[parallax_elements_bg.length] = scale - 1;
	parallax_offsets_bg[parallax_elements_bg.length] = offset;
	parallax_elements_bg[parallax_elements_bg.length] = element;
}

function updateParallax(index, windowX, windowY, width, height) {
	parallax_elements[index].style.top =
			((parallax_Yorigins[index]
			- (windowY + height - parallax_heights[index]))
			* parallax_Yscales[index]) + "px";
	parallax_elements[index].style.left =
			((parallax_Xorigins[index]
			- (windowX + width - parallax_widths[index]))
			* parallax_Xscales[index]) + "px";
}
function updateParallaxBackgrounds(index, window_top) {
	var str = parallax_elements_bg[index].style.backgroundPosition;
	if (str.indexOf(" ") > 0)
		str = str.substr(0, str.indexOf(" ") + 1);
	else
		str = "0px ";
	str += ((-window_top * parallax_scales_bg[index])
			- parallax_offsets_bg[index]) + "px";
	parallax_elements_bg[index].style.backgroundPosition = str;
	
	/*
	parallax_elements_bg[index].style.backgroundPosition =
			parallax_elements_bg[index].style.backgroundPosition.indexOf(" ")
			> 0 ? parallax_elements_bg[index].style.backgroundPosition.substr(
			parallax_elements_bg[index].style.backgroundPosition.indexOf(" "))
			: "0px ") + ((-window_top * parallax_scales_bg[index])
			- parallax_offsets_bg[index]) + "px";
	*/
}

function updateAllParallaxElements() {
	var windowX = window.pageXOffset;
	var windowY = window.pageYOffset;
	var width = window.innerWidth / 2;
	var height = window.innerHeight / 2;
	for (i = 0; i < parallax_elements.length; ++i)
		updateParallax(i, windowX, windowY, width, height);
	for (i = 0; i < parallax_elements_bg.length; ++i)
		updateParallaxBackgrounds(i, windowY);
}

// jQuery events and such
$(window).resize(updateAllParallaxElements);
$(window).scroll(updateAllParallaxElements);
$(document).ready(updateAllParallaxElements);