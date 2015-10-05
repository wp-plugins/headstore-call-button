(function( $ ) {
    
    function hs_form_generate_shortcode() { 
	  // Form here!
		var form = jQuery('<div id="hs-shortcode-form"><table id="hs-shortcode-table" class="form-table">\
		     <input type="hidden" id="hs-shortcode-type" value="">\
			<tr>\
				<th><span title="' + values.label_username_input_title + '"><label for="hs-shortcode-username">' +  values.label_username + '</label></span></th>\
				<td><span title="' + values.label_username_input_title + '"><select name="size" id="hs-shortcode-username">' + values.options_users + '</span></td>\
			</tr>\
			<!--tr>\
				<th><span title="' + values.label_campaign_input_title + '"><label for="hs-shortcode-campaign">' + values.label_campaign + '</label></span></th>\
				<td><span title="' + values.label_campaign_input_title + '"><input type="text" id="hs-shortcode-campaign" name="campaign" value="" /></span></td>\
			</tr-->\
			<tr id="hs-shortcode-group_or_expert_id_tr">\
				<th><span title="' + values.label_expert_input_title + '"><label for="hs-shortcode-group_or_expert_id">' +  values.label_expert + '</label><br>\
		            <!--label class="hs-subinfo">' + values.label_expert_subinfo + '</label--></span></th>\
				<td><span title="' + values.label_expert_input_title + '"><select name="size" id="hs-shortcode-group_or_expert_id">' + values.options_experts_list + '</select></span></td>\
			</tr>\
			<tr id="hs-shortcode-design_tr">\
				<th><span title="' + values.label_design_input_title + '"><label for="hs-shortcode-design">' +  values.label_design + '</label></span></th>\
				<td><span title="' + values.label_design_input_title + '">\
					   <input type="radio" id="hs-shortcode-design" name="hs-shortcode-design" value="1"  checked> Big<br>\
	                   <input type="radio" id="hs-shortcode-design" name="hs-shortcode-design" value="2" > Small<br>\
		            </span></td>\
			</tr>\
			<tr>\
			<th></th>\
			<td><span title="Preview" id="hs-shortcode-preview">\
				 </span></td>\
		</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="hs-shortcode-submit" class="button-primary" value="' + values.label_insert_button + '" name="submit" />\
		</p>\
		' + values.hs_token_hiddens + '</div>');
		return form;
  }
   
    function hs_form_update_preview() {
    	var type = $(document).find('#hs-shortcode-group_or_expert_id').find(":selected").data('type');
    	var expert = $(document).find('#hs-shortcode-group_or_expert_id').find(":selected")[0].value;
    	var design = $(document).find("input:radio[name=hs-shortcode-design]:checked")[0].value;
    	$preview = '<iframe src="https://'+values.backend_url+'/callme/?dataFrom='+type+'&preview=1&type=SINGLE_EXPERT&'+(type=="COMPANY_GROUP"?"groupId":"expertId")+'='+expert+'&DESIGN='+design+'" width="210" height="300px" frameborder="0" id="ext-gen1496" se-id="uxiframe-0_0"></iframe>';
        
    	$(document).find('#hs-shortcode-preview').html($preview);
    }

	$(document).ready(function() {
		
		var form = hs_form_generate_shortcode();
		var table = form.find('table');
		
		form.appendTo('body').hide();
		
		var first_type = table.find('#hs-shortcode-group_or_expert_id option:selected').data('type');
		
		table.find('#hs-shortcode-type').val(first_type);
		
		table.find('#hs-shortcode-username').change( function(event) { 
		    var option_select = $(this).find(":selected").val();
	    	var token_id = $(this).find(":selected").data('token');
	    	var token = $('#hs_token_' + token_id).val();
  	     	table.find('#hs-shortcode-group_or_expert_id').find('option').remove().end();
			
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
            			if (json.experts_list == '') {
            				$(document).find('#hs-shortcode-group_or_expert_id_tr').hide();
            				$(document).find('#hs-shortcode-design_tr').hide();
            				$(document).find('#hs-shortcode-preview').html('No Call-Me buttons found for this Account.<br />' +
            				'Go to <a target="_blank" href="'+values.backend_url+'">headstore.com</a> to create your first Call-Me button.<br /><br /><br />');
            				
            			}
            			else {
            				$(document).find('#hs-shortcode-group_or_expert_id_tr').show();
            				$(document).find('#hs-shortcode-design_tr').show();
            				table.find('#hs-shortcode-group_or_expert_id').append(json.experts_list);
            			}
				
            		} else {
        			
    					alert(json.message);
					
            		}
				
            	},
                error: function(xhr, options, exc) {
                    console.log(exc);
                }
            });
			
            hs_form_update_preview();
		});
		
		table.find('#hs-shortcode-group_or_expert_id').change( function(event) { 
			
			var type = $(this).find(":selected").data('type');
			$('#hs-shortcode-type').val(type);
			hs_form_update_preview();
		});
		
		table.find('input:radio[name=hs-shortcode-design]').change( function(event) { 
			hs_form_update_preview();
		});
		form.find('#hs-shortcode-submit').click(function(){

			var options = { 
				'group_or_expert_id'  : '',
				'design'    : '',
				'campaign'  : '',
				'type' : ''
			};
			
			var shortcode = '[' + values.shortcode_name;
			
			for( var index in options) {
				 var value;
				 if(index == 'design'){
				 	value = table.find('input:radio[name=hs-shortcode-' + index + ']:checked').val();
				 } else {
				 	 value = table.find('#hs-shortcode-' + index).val();
			     }

				if ( value !== options[index] )
					shortcode += ' ' + index + '=' + value + '';
			}
			
			shortcode += ']';

			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

			tb_remove();
		});
		   
	 hs_form_update_preview();
	 });	  

})( jQuery );


