(function($ ){
  
   var width,height;	
  
	tinymce.create('tinymce.plugins.headstore', {

		createControl : function(id, controlManager) {
			
			width = 520;
			height = 600;
			 
			 
			if (id == 'headstore_button') {
				// creates the button
				var button = controlManager.createButton('headstore_button', {
					text: 'Headstore',
					title : 'Insert Shortcode', // title of the button
					image : '../wp-content/plugins/headstore-call-button/images/headstore-icon-blue.png',  // path to the button's image
					onclick : function() {
						// triggers the thickbox
						hs_caculate_width_and_height();
						tb_show( 'HEADSTORE Shortcode', '#TB_inline?width=' + width + '&height=' + height + '&inlineId=hs-shortcode-form' );
						hs_resize_headstore_shortcode();
					}
				});
				return button;
			}
			return null;
		}
	});
	
	tinymce.PluginManager.add('headstore', tinymce.plugins.headstore);
	
    jQuery(window).resize(function(){ 
		hs_caculate_width_and_height();
		hs_resize_headstore_shortcode(); 
	}); 
   
   function hs_resize_headstore_shortcode(){ 
         $(document).find('#TB_window, #TB_ajaxContent').width(TB_WIDTH).height(TB_HEIGHT); 
   } 
   
   function hs_caculate_width_and_height(){
		var width = jQuery(window).width(), 
	        height = jQuery(window).height(), 
	        width = ( 720 < width ) ? 720 : width;
		width = width - 40;
		height = height - 64;
   }
	   
})(jQuery)


