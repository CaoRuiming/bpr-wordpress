var issuuPanel = {
	params : {
	    allowfullscreen: 'true',
	    menu: 'false',
	    wmode: 'transparent'
	},
	flashvars : {
	    jsAPIClientDomain: window.location.hostname,
	    mode: 'mini'
	}
};
(function($){
	$(document).ready(function(){
		$('[data-issuu-viewer]').each(function(){
			issuuPanel.flashvars.documentId = $(this).data('document-id');
			var id = $(this).data("issuu-viewer");
			swfobject.embedSWF(
				"https://static.issuu.com/webembed/viewers/style1/v2/IssuuReader.swf",
				id,
				"100%",
				"323",
				"9.0.0",
				"https://static.issuu.com/webembed/viewers/style1/v2/IssuuReader.swf",
				issuuPanel.flashvars,
				issuuPanel.params,
				{id : id}
			);
		});
		$('[data-toggle="issuu-embed"]').click(function(e){
			e.preventDefault();
			issuuPanel.flashvars.documentId = $(this).attr('href');
			var id = $(this).data('target');

			swfobject.embedSWF(
		    	"https://static.issuu.com/webembed/viewers/style1/v2/IssuuReader.swf",
		    	id,
		    	"100%",
		    	"323",
		    	"9.0.0",
		    	"https://static.issuu.com/webembed/viewers/style1/v2/IssuuReader.swf",
		    	issuuPanel.flashvars,
		    	issuuPanel.params,
		    	{id : id}
		    );

			var top = $('#' + id).offset().top - 50;
			$('html, body').animate({scrollTop : top}, 'slow');
		});
		$('[data-toggle="issuu-panel-reader"]').click(function(e){
			e.preventDefault();
			$('body').addClass('issuu-panel-noscroll');
			var parameters = '?action=open_issuu_panel_reader&docId=' + $(this).attr('href') + '&pageCount='
				+ $(this).attr('data-count-pages');
			$('<div>',{
				id : 'issuu-panel-reader'
			}).appendTo('body');
			$('<iframe>', {
				id : 'ip-iframe-reader',
				src : issuuPanelReaderObject.adminAjax + parameters
			})
			.appendTo('#issuu-panel-reader')
			.load(function(){
				$(this).issuuPanelReader();
				$iframe = $(this).contents();
			});
			$(document).keyup(function(e){
				if (e.keyCode == 27)
				{
					$('#issuu-panel-reader').fadeOut(500, function(){
						$(this).remove();
						$iframe = null;
					});
				}
			});
			$('#issuu-panel-reader').hide().fadeIn(500);
			$tools = $('<div>', {
				id : 'issuu-panel-reader-tools'
			}).appendTo('#issuu-panel-reader');
			$('<div>', {
				'class' : 'issuu-panel-reader-tools ip-zoom-max'
			}).appendTo($tools);
			$('<div>', {
				'class' : 'issuu-panel-reader-tools ip-zoom-more'
			}).appendTo($tools);
			$('<div>', {
				'class' : 'issuu-panel-reader-tools ip-zoom-minus'
			}).appendTo($tools);
			$('<div>', {
				'class' : 'issuu-panel-reader-tools ip-zoom-min'
			}).appendTo($tools);
			$('<div>', {
				'class' : 'issuu-panel-reader-tools ip-close-reader'
			}).appendTo($tools);
			$nav = $('<nav>').appendTo('#issuu-panel-reader');
			$ul = $('<ul>').appendTo($nav);
			$prev = $('<li>').appendTo($ul);
			$next = $('<li>').appendTo($ul);
			$('<a>', {
				href: '#',
				id : 'ip-reader-prev',
				'class' : 'ip-reader-navigation'
			}).appendTo($prev);
			$('<a>', {
				href: '#',
				id : 'ip-reader-next',
				'class' : 'ip-reader-navigation'
			}).appendTo($next);
		});

		$('.issuu-painel-paginate').each(function(){
			var paginate_html = $(this).html();
			var regex = /(\<p\>|\<\/p\>)/;

			paginate_html = paginate_html.replace(regex, '');
			$(this).html(paginate_html);
		});
	});
})(jQuery);