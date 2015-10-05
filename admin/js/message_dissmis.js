(function( $ ) {
    

	$(document).ready(function() {
		
		$('#hs-message-dismiss').click(function() { 
			
			
            keys = [{
				'name_msj': values.name_msj }];
			
            $.ajax( {
            	url: values.id_ajaxurl,
            	type: 'POST',
            	data: {action: values.action, Keys: keys},
            	success: function(response) {
            		console.log(response);
            		var json = JSON.parse(response);
            		if (json.response == 'success') {
						
						$('#' + values.div_msj).remove();
				
            		} else {
        			
    					alert(json.message);
					
            		}
				
            	},
                error: function(xhr, options, exc) {
                    console.log(exc);
                }
            });
		
		});
		
   	 });

})( jQuery );


