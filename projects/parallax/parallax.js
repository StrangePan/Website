/**
 *
 * Using this script is very simple.
 * To apply a parallaxing effect to an HTML element, call the function
 * "parallax" in JavaScript.
 * To apply a parallax effect to the background of an HTML element, call the function
 * "parallaxBackground" in JavaScript.
 *
 * This script REQUIRES that jQuery be already loaded on the page.
 *
 */

var parallax_elements = new Array();

function parallax(element, parallax) {
	for (i = 0; i < parallax_elements.length; ++i) {
		if (parallax_elements[i].element == element) {
			if (parallax) parallax_elements[i].parallax = parallax;
			parallax_elements[i].updateParallax();
			return;
		}
	}
	parallax_elements[parallax_elements.length] =
			new ParallaxElement(element, parallax);
	parallax_elements[parallax_elements.length - 1].updateParallax();
}
function parallaxBackground(element, parallax, offset) {
	for (i = 0; i < parallax_elements.length; ++i) {
		if (parallax_elements[i].element == element) {
			if (offset) parallax_elements[i].backgroundYOffset = offset;
			if (parallax) parallax_elements[i].backgroundParallax = parallax;
			parallax_elements[i].updateBackgroundParallax();
			return;
		}
	}
	parallax_elements[parallax_elements.length] =
			new ParallaxElement(element, 0, parallax, offset);
	parallax_elements[parallax_elements.length - 1].updateBackgroundParallax();
}

function updateAllParallaxElements() {
	var windowY = window.pageYOffset;
	var height = window.innerHeight;
	for (i = 0; i < parallax_elements.length; ++i) {
		parallax_elements[i].updateParallax(windowY, height);
		parallax_elements[i].updateBackgroundParallax(windowY);
	}
}

// jQuery events and such
/*
$(window).resize(updateAllParallaxElements);
$(window).scroll(updateAllParallaxElements);
*/
$(window).resize(function() {
  window.requestAnimationFrame(updateAllParallaxElements);
});
$(window).scroll(function() {
  window.requestAnimationFrame(updateAllParallaxElements);
});

// Object definitions
function ParallaxElement(element, parallax, backgroundParallax, backgroundYOffset) {
	this.element = element;
	this.parallax = (parallax ? parallax : 0);
	this.backgroundParallax = (backgroundParallax ? backgroundParallax : 0);
	this.backgroundYOffset = (backgroundYOffset ? backgroundYOffset : 0);
	this.width = 0;
	this.height = 0;
	this.x = 0;
	this.y = 0;
	this.enabled = true;
	this.frozen = false;
	
	this.disable = function() {
		this.enabled = false;
	}
	this.enable = function() {
		this.enabled = true;
	}
	this.freeze = function() {
		this.frozen = true;
	}
	this.unfreeze = function() {
		this.frozen = false;
	}
	
	this.updateProperties = function() {
		this.width = $(element).width();
		this.height = $(element).height();
		this.x = $(element).offset().left;
		this.y = $(element).offset().top;
	}
	this.updateParallax = function(windowY, windowHeight) {
		if (this.frozen) return;
		if (!this.enabled) this.element.style.top = "auto";
		
		this.element.style.top = (this.parallax * (this.y
				- ((windowY == undefined ? window.pageYOffset : windowY)
				+ ((windowHeight == undefined ? window.innerHeight : windowHeight) >>> 1)
				- (this.height >>> 1)))) + "px";
	}
	this.updateBackgroundParallax = function(windowY) {
		if (this.frozen) return;
		
		// Only update if within view
		if ($(this.element).offset().top > $(window).scrollTop() + $(window).height()) return;
		if ($(this.element).offset().top + $(this.element).height() < $(window).scrollTop()) return;
		
		// Calculate new background position
		this.element.style.backgroundPosition =
				(this.element.style.backgroundPosition.indexOf(" ") > 0 ?
						this.element.style.backgroundPosition.substr(0, this.element.style.backgroundPosition.indexOf(" ") + 1) :
						"0px ")
				+ ((this.enabled ? ((windowY == undefined ? window.pageYOffset : windowY) * this.backgroundParallax) : 0)
						+ this.backgroundYOffset) + "px";
	}
	
	this.updateProperties();
}