(function(){
	
	tinymce.PluginManager.requireLangPack( otw_shortcode_component.tinymce_button_key );
	
	tinymce.create('tinymce.plugins.' + otw_shortcode_component.tinymce_button_key + 'Plugin', {
	
		init : function(ed, url) {
			
			
			ed.addCommand(otw_shortcode_component.tinymce_button_key + 'Command', function( ui, v ) {
				
				if( typeof( v ) == 'object' && v.size() ){
					otw_shortcode_component.open_drowpdown_menu( v );
				}else{
					otw_shortcode_component.open_drowpdown_menu( jQuery( '#content_' + otw_shortcode_component.tinymce_button_key ).parent() );
				}
				otw_shortcode_component.insert_code = function( shortcode_object ){
					
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, shortcode_object.shortcode_code );
					tb_remove();
				}
			});
			
			// Register example button
			ed.addButton( otw_shortcode_component.tinymce_button_key, {
				
				title : 'Insert ShortCode',
				/*cmd :  otw_shortcode_component.tinymce_button_key + 'Command',*/
				image : url + '/../images/otw-sbm-icon.png',
				onclick: function( p1 ){
					
					jQuery( '#' + this._id ).attr( 'data-otwkey', otw_shortcode_component.tinymce_button_key  );
					ed.execCommand( otw_shortcode_component.tinymce_button_key + 'Command', true, jQuery( '#' + this._id ) );
					
				}
			});
			
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive( otw_shortcode_component.tinymce_button_key, n.nodeName == 'IMG');
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return { 
				longname : 'OTW Shortcode Component',
				author : 'OTWthemes.com',
				authorurl : 'http://themeforest.net/user/OTWthemes',
				infourl : 'http://OTWthemes.com',
				version : "1.0"
			}
		}
	});
	
	// Register plugin
	tinymce.PluginManager.add( otw_shortcode_component.tinymce_button_key, tinymce.plugins[ otw_shortcode_component.tinymce_button_key + 'Plugin' ]);
	
})();