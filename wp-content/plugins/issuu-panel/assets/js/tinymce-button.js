(function(){
	tinymce.create('tinymce.plugins.IssuuPanel', {
		init : function(ed, url) {
			ed.addCommand('IssuuPanelCommand', function(){
				ed.windowManager.open({
					file: ajaxurl + '?action=issuu_panel_tinymce_ajax',
					width: 420,
					height: 235,
					inline: 1
				});
			});

			ed.addButton('issuupanel', {
				title : 'Issuu Panel Shortcode',
				image : url + '/../images/issuu-painel-tinymce-button.png',
				cmd: 'IssuuPanelCommand'
			});
		},
		getInfo : function(){
			return {
				longname : "Issuu Panel",
				author : 'Pedro Marcelo',
				authorurl : 'https://github.com/pedromarcelojava/',
				infourl : 'https://github.com/pedromarcelojava/Issuu-Painel/',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('issuupanel', tinymce.plugins.IssuuPanel);
})();