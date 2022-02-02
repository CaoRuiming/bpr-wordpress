jQuery( document ).ready(function($) {
	var $window = $(window),
		flexslider = { vars:{} };
 
	// tiny helper function to add breakpoints
	function getGridfnsSize() {
	return (window.innerWidth < 481) ? 1 :
			(window.innerWidth < 768) ? 2 :
	       (window.innerWidth < 1024) ? 3 : 4;
	}

	function getGridmultiSize() {
	return (window.innerWidth < 481) ? 1 :
			(window.innerWidth < 768) ? 2 :
	       (window.innerWidth < 1024) ? 3 : 4;
	}

	$('.layer-slider').flexslider({
	    animation: magbook_slider_value.magbook_animation_effect,
	    animationLoop: true,
	    slideshow: true,
	    slideshowSpeed: magbook_slider_value.magbook_slideshowSpeed,
	    animationSpeed: magbook_slider_value.magbook_animationSpeed,
	    smoothHeight: true
	});

	$('.multi-slider').flexslider({
	    animation: "slide",
	    animationLoop: true,
	    slideshow: true,
	    slideshowSpeed: magbook_slider_value.magbook_slideshowSpeed,
	    animationSpeed: magbook_slider_value.magbook_animationSpeed,
	    smoothHeight: true,
	    itemWidth: 200,
	    itemMargin: 1,
		move: 1,
		minItems: getGridmultiSize(), // use function to pull in initial value
		maxItems: getGridmultiSize() // use function to pull in initial value
	});

	$('.small-slider').flexslider({
	    animation: magbook_slider_value.magbook_animation_effect,
	    animationLoop: true,
	    slideshow: true,
	    slideshowSpeed: magbook_slider_value.magbook_slideshowSpeed,
	    animationSpeed: magbook_slider_value.magbook_animationSpeed,
	    smoothHeight: true
	});

	$('.feature-news-slider').flexslider({
		animation: "slide",
		animationLoop: true,
		slideshow: true,
		controlNav: false,
		smoothHeight: false,
		slideshowSpeed: 5000,
		animationSpeed: 500,
		pauseOnHover: true,
		itemWidth: 200,
		itemMargin: 30,
		move: 1,
		minItems: getGridfnsSize(), // use function to pull in initial value
		maxItems: getGridfnsSize() // use function to pull in initial value
	});

	$('.breaking-news-slider').flexslider({
		animation: "slide",
		animationLoop: true,
		direction: "vertical",
		slideshow: true,
		controlNav: false,
		directionNav: true,
		smoothHeight: false,
		slideshowSpeed: 3000,
		animationSpeed: 1000,
		pausePlay: true,
		pauseText: 'Pause',
		playText: 'Play'
	});

	$window.resize(function() {
	    var gridSize = getGridfnsSize();
	    var gridSize = getGridmultiSize();
	 
	    flexslider.vars.minItems = gridSize;
	    flexslider.vars.maxItems = gridSize;
	});
});

		