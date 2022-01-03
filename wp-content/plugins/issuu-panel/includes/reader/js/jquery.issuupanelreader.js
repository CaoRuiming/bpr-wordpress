/*
*	jQuery Issuu Panel Simple Reader
*
*
*	Author: Pedro Marcelo
*	Version: 1.0
*/

var $nav, $ul, $prev, $next, $iframe, $tools;
var keyMap = {
	16 : false,
	17 : false,
	37 : false,
	38 : false,
	39 : false,
	40 : false
};

(function($){
	$.fn.issuuPanelReader = function(options){
		var defaults = {
			prevNavigation : "#ip-reader-prev",
			nextNavigation : "#ip-reader-next",
			zoomMax : '.ip-zoom-max',
			zoomMore : '.ip-zoom-more',
			zoomMinus : '.ip-zoom-minus',
			zoomMin : '.ip-zoom-min',
			closeReader : '.ip-close-reader'
		};
		$.issuuPanelReaderIframe = $(this).contents();
		$.issuuPanelReader = {
			zoom : 100
		};

		$(this).on('mousedown', function(e) {
			$(this).on('mousemove', function(evt) {
				$.issuuPanelReaderIframe.find('html,body').stop(false, true).animate({
					scrollLeft: e.pageX - evt.clientX
				});
			});
		});
		$(this).on('mouseup', function() {
			$(this).off('mousemove');
		});

		options = $.extend({}, defaults, options);

		$(options.prevNavigation).click(function(e){
			e.preventDefault();
			var page = $.issuuPanelReaderIframe.find('.ip-doc-active');
			var pageNumber = page.find('img').data('ip-reader-page');

			if (pageNumber > 1)
			{
				pageNumber--;
				$.issuuPanelReader.zoom = 100;
				page.removeClass('ip-doc-active');
				$.issuuPanelReaderIframe
					.find('[data-ip-reader-page="' + pageNumber + '"]').parent().addClass('ip-doc-active');
				$.issuuPanelReaderIframe.find('body').css({zoom : $.issuuPanelReader.zoom + '%'});
			}
		});

		$(options.nextNavigation).click(function(e){
			e.preventDefault();
			var countPages = parseInt($.issuuPanelReaderIframe.find('#issuu-panel-document').data('ip-reader-pages'));
			var page = $.issuuPanelReaderIframe.find('.ip-doc-active');
			var pageNumber = page.find('img').data('ip-reader-page');

			if (pageNumber < countPages)
			{
				pageNumber++;
				$.issuuPanelReader.zoom = 100;
				page.removeClass('ip-doc-active');
				$.issuuPanelReaderIframe
					.find('[data-ip-reader-page="' + pageNumber + '"]').parent().addClass('ip-doc-active');
				$.issuuPanelReaderIframe.find('body').css({zoom : $.issuuPanelReader.zoom + '%'});
			}
		});

		$(options.zoomMax).click(function(e){
			e.preventDefault();

			if ($.issuuPanelReader.zoom < 500)
			{
				$.issuuPanelReader.zoom = 500;
				$.issuuPanelReaderIframe.find('#issuu-panel-document').css({zoom : $.issuuPanelReader.zoom + '%'});
			}
		});

		$(options.zoomMore).click(function(e){
			e.preventDefault();

			if ($.issuuPanelReader.zoom < 500)
			{
				if ($.issuuPanelReader.zoom < 200)
				{
					$.issuuPanelReader.zoom += 10;
				}
				else
				{
					$.issuuPanelReader.zoom += 20;
				}
			}

			$.issuuPanelReaderIframe.find('#issuu-panel-document').css({zoom : $.issuuPanelReader.zoom + '%'});
		});

		$(options.zoomMinus).click(function(e){
			e.preventDefault();

			if ($.issuuPanelReader.zoom > 100)
			{
				if ($.issuuPanelReader.zoom > 200)
				{
					$.issuuPanelReader.zoom -= 20;
				}
				else
				{
					$.issuuPanelReader.zoom -= 10;
				}
			}

			$.issuuPanelReaderIframe.find('#issuu-panel-document').css({zoom : $.issuuPanelReader.zoom + '%'});
		});

		$(options.zoomMin).click(function(e){
			e.preventDefault();

			if ($.issuuPanelReader.zoom > 100)
			{
				$.issuuPanelReader.zoom = 100;
				$.issuuPanelReaderIframe.find('#issuu-panel-document').css({zoom : $.issuuPanelReader.zoom + '%'});
			}
		});

		$(options.closeReader).click(function(e){
			$('#issuu-panel-reader').fadeOut(500, function(){
				$(this).remove();
				$iframe = null;
				$(window).unbind('keyup').unbind('keydown');
				$('body').removeClass('issuu-panel-noscroll');
			});
		});

		$(document).keydown(function(e){
			switch(e.keyCode) {
				case 27:
					$(options.closeReader).trigger('click');
					break;
				default:
					if (e.keyCode in keyMap) {
						keyMap[e.keyCode] = true;
						if (keyMap[17] && keyMap[37]) {
							$(options.prevNavigation).trigger('click');
							return false;
						} else if (keyMap[17] && keyMap[16] && keyMap[38]) {
							$(options.zoomMax).trigger('click');
							return false;
						} else if (keyMap[17] && keyMap[38]) {
							$(options.zoomMore).trigger('click');
							return false;
						} else if (keyMap[17] && keyMap[39]) {
							$(options.nextNavigation).trigger('click');
							return false;
						} else if (keyMap[17] && keyMap[16] && keyMap[40]) {
							$(options.zoomMin).trigger('click');
							return false;
						} else if (keyMap[17] && keyMap[40]) {
							$(options.zoomMinus).trigger('click');
							return false;
						}
					}
					break;
			}
		}).keyup(function(e){
		    if (e.keyCode in keyMap) {
		        keyMap[e.keyCode] = false;
		    }
		});

		return this;
	}
})(jQuery);