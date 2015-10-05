(function( $ ) {
    
	

	$(document).ready(function() {
		
	    var shareButton = new ShareButton({
	      networks: {
  	          facebook:{
           		url: add_share_button.url,
           		//appId: "1007527835932544",
          	  	description: add_share_button.comment,
              },
	          googlePlus: {
	            url: add_share_button.url
	          },
	         linkedin: {
	           url: add_share_button.url,
	           description: add_share_button.comment
	         },
	        twitter: {
	          url: add_share_button.url,
	          description: add_share_button.comment
	        },
		    pinterest: {
	          url:  add_share_button.url,
	          description: add_share_button.comment
	        },
	        whatsapp: { enabled: false },
	        reddit: { enabled: false },
	        email: { enabled: false }
	      },
	      ui: {
	        flyout: 'center bottom'
	      }
	    });
		
		
   	 });

})( jQuery );


