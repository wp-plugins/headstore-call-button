(function( $ ) {
    
	

	$(document).ready(function() {
		
		var email_account = $('#email_account');
		var email_spinnel = $('#hs_spinner_email');
		var email_message_error = $('#message-check-email-error');
		var email_message_succeeded = $('#message-check-email-succeeded');
		var button_publish = $('#publish, #button-submit');
		var button_connect = $('#hs-button-connect');
		var email_original = $.trim(email_account.val());
		var email_current = email_original;
		var email_new = '';
		if(hs_values_admin.enabled_buttons){
			button_publish.attr('disabled','disabled');
			button_connect.attr('disabled','disabled');
	    }
		
		email_account.focusout(function() { 
			
			email_new = $.trim($(this).val());
			
			if(email_current == email_new ) return;
			
			email_current = email_new;
			
			email_message_error.hide();	
			
			email_message_succeeded.hide();	
			
			if(email_original == email_new) return;
			
			button_publish.attr('disabled','disabled');
			
			button_connect.attr('disabled','disabled');
			
			email_spinnel.addClass('is-active');

            keys = [{
				'email': $(this).val()
			}];
			
            $.ajax( {
            	url: hs_values_admin.id_ajaxurl,
            	type: 'POST',
            	data: {action: hs_values_admin.action_check_user, Keys: keys},
            	success: function(response) {
            		console.log(response);
            		var json = JSON.parse(response);
            		if (json.response == 'success') {
						button_publish.removeAttr('disabled');
						button_connect.removeAttr('disabled');
            		} else {
						email_message_error.show();	
						email_message_error.find('.text').text(json.message);
            		}
				   email_spinnel.removeClass('is-active');
            	},
                error: function(xhr, options, exc) {
                    console.log(exc);
					email_spinnel.removeClass('is-active');
                }
            });
			 
		
		});
		
		button_connect.click(function() { 
			$(this).attr('disabled','disabled');
			button_publish.trigger('click');
		});
		

	    $(window).keydown(function(event){
	       if(event.keyCode == 13) {
	         event.preventDefault();
	         return false;
	       }
	     });
		
		
   	 });

})( jQuery );


