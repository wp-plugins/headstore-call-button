(function( $ ) {
    

	$(document).ready(function() {
		
		print_shortcode();
		
		$( '#group_id' ).change(function() {
		  window.location = window.location.href + '&hs_group_id=' + $('#group_id').find(":selected").val();
		});
		
		$( '#campaign_id' ).keyup(function() {
				print_shortcode();
		});
		
		$('input:radio[name=design]').click(function() {
			print_shortcode();
		});
		   
	 });
	 
	 function print_shortcode() {
		 
		 var group_id = $('#group_id').find(":selected").val();
		 var design =  $('input:radio[name=design]:checked').val();
		 var campaign_id  = $('#campaign_id').val();
		 var attr_campaign_id = '';
		 if(campaign_id) attr_campaign_id = ' campaign='+campaign_id;
		 
		 $( "#shortcode_place" ).html('[' + values.shortcode_name + ' group_id=' + group_id + ' design=' +  design + attr_campaign_id + ']');
	 } 
	 
	 
   	 function put_design(data_group_id) {
		 
   		  for (var j = 1; j < 4; j++) {
			  
   			  $( "#hs_sc_design_" + j ).html('<div class="callme-button" data-group="' +data_group_id + '" data-design="' + j + '"></div>');
   		  }
		  
   	 }

})( jQuery );


