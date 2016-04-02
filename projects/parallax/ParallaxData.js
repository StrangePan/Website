function ParallaxElement(element) {
	this.element = element;
	this.parallax = 0;
	this.backgroundParallax = 0;
	this.backgroundYOffset = 0;
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
		this.y = $(element).ofset().top;
	}
	this.updateParallax = function(windowY, windowHeight) {
		if (this.frozen) return;
		if (!this.enabled) this.element.style.top = "auto";
		
		this.element.style.top = (this.parallax * (this.y
				- ((windowY == undefined ? window.pageYOffset : windowY)
				+ ((windowHeight == undefined ? window.innerHeight : windowHeight) >>> 1)
				- this.height))) + "px";
	}
	this.updateBackgroundParallax = function(windowY) {
		if (this.frozen) return;
		
		this.element.style.backgroundPosition =
				(this.element.style.backgroundPosition.indexOf(" ") > 0
					? this.element.style.backgroundPosition.substr(0,
						this.element.style.backgroundPosition.indexOf(" ") + 1)
					: "0px ") + ((this.enabled ? (-windowY * this.backgroundParallax) : 0)
					+ this.backgroundYOffset) + "px";
	}
}