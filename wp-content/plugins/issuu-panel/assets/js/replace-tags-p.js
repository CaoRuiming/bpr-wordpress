(function($){
	$('.issuu-painel-paginate').each(function(){
		var paginate_html = $(this).html();
		var regex = /(\<p\>|\<\/p\>)/;

		paginate_html = paginate_html.replace(regex, '');
		$(this).html(paginate_html);
	});
})(jQuery);