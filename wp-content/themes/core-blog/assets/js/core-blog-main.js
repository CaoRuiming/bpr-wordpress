(function($) {
	var	$window = $(window),
		$body = $('body'),
		$sidebar = $('#sidebar'),
		$main = $('#main');

	// Breakpoints.
		breakpoints({
			xlarge:   [ '1281px',  '1680px' ],
			large:    [ '981px',   '1280px' ],
			medium:   [ '737px',   '980px'  ],
			small:    [ '481px',   '736px'  ],
			xsmall:   [ null,      '480px'  ]
		});

	// Play initial animations on page load.
		$window.on('load', function() {
			window.setTimeout(function() {
				$body.removeClass('is-preload');
			}, 100);
		});

	
	// Intro.
		var $intro = $('#intro');

		// Move to main on <=large, back to sidebar on >large.
			breakpoints.on('<=large', function() {
				$intro.prependTo($main);
			});

			breakpoints.on('>large', function() {
				$intro.prependTo($sidebar);
			});
	//main navigation
	$('.core-blog-main-navigation ul li.menu-item-has-children').find('> a').after('<button class="submenu-toggle"><i class="fa fa-chevron-down"></i></button>');
	$('.core-blog-main-navigation ul li.page_item_has_children').find('> a').after('<button class="submenu-toggle"><i class="fa fa-chevron-down"></i></button>');
	$('.core-blog-main-navigation ul li button.submenu-toggle').on('click', function() {
		$(this).parent('li.menu-item-has-children').toggleClass('active');
		$(this).parent('li.page_item_has_children').toggleClass('active');
		$(this).siblings('.sub-menu').stop(true, false, true).slideToggle();
		$(this).siblings('.children').stop(true, false, true).slideToggle();
	});
	$('.core-blog-main-navigation .toggle-button').click(function() {
		$('.primary-menu-list').animate({
			width: 'toggle',
		});
	});
	$('.core-blog-main-navigation .close').click(function() {
		$('.primary-menu-list').animate({
			width: 'toggle',
		});
	});
	//for accessibility
	$('.core-blog-main-navigation ul li a, .core-blog-main-navigation ul li button').focus(function() {
		$(this).parents('li').addClass('focused');
	}).blur(function() {
		$(this).parents('li').removeClass('focused');
	});
})(jQuery);
jQuery(document).ready(function() {
	
	jQuery('.menu-close').click(function() {
		jQuery('body').removeClass('is-menu-visible');
	});
});
jQuery(document).ready(function() {
	jQuery('.core-blog-search').hide();
	jQuery(".search_f").click(function() {
		jQuery(".core-blog-search").toggle('slow');
		jQuery(".core-blog-search .search-field").focus();
	});
	jQuery('.focus_search').focus(function() {
		jQuery('.core-blog-search').hide('slow'); //hide the button
	});
});

function topFunction() {
	document.body.scrollTop = 0; // For Safari
	document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
jQuery(document).ready(function() {
	mybutton = document.getElementById("myBtn");
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function() {
		scrollFunction()
	};

	function scrollFunction() {
		if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			mybutton.style.display = "block";
		} else {
			mybutton.style.display = "none";
		}
	}
});