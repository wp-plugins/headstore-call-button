(function( $ ) {
    

	$(document).ready(function() {
		//add_options_expert();
	 });
	 
	 $( document ).ajaxStop( function() {
		 //add_options_expert();
	  } );
	  
	  
	  function add_options_expert() {
		 
	     var username = $('[id*="username"]' );
		 
		 var experts = $('[id*="expert"]' );
		  
	     username.unbind( 'change' );
		 
  		 username.bind('change', function(event) {

  		 var option_select = $(this).find(":selected").val();
  	     var token_id = $(this).find(":selected").data('token');
  		 var token = $('#hs_token_' + token_id).val();
		 var expert = 'select#' + $(this).attr('id').replace('username', 'expert');
		 
  		$(expert)
  		    .find('option')
  		    .remove()
  		    .end();

           keys = [{
  	        'email': option_select,
  			'token': token }];
			
          jQuery.ajax( {
          	url: values.id_ajaxurl,
          	type: 'POST',
          	data: {action: 'hs_get_experts_ajax', Keys: keys},
          	success: function(response) {
          		console.log(response);
          		var json = JSON.parse(response);
          		if (json.response == 'success') {
					
  					$(expert).append(json.experts_list);
				
          		} else {
        			
  					alert(json.message);
					
          		}
				
          	},
              error: function(xhr, options, exc) {
                  console.log(exc);
              }
          });
		  
  		});
		
		experts.each(function() {
			change_type(this);
		});
		
		experts.bind('change', function(event) {
			change_type(this);
		});
		
	  }
	  
	  function change_type(expert) {
	     var type = $(expert).find(":selected").data('type');
		 var type_id = '#' + $(expert).attr('id').replace('expert', 'type');
		 $(type_id).val(type);
	  }

})( jQuery );


