<?php

$title_campaign = __('If you have multiple "Call-Me Buttons" the Campaign ID lets you identify which one is in use. For example if you use the same button on several sites, you can determine which site the call came from.', $this->plugin_name);

$title_widget_title = __('This title will appear above your "Call-Me Button".', $this->plugin_name);

$title_username = __('If you have multiple HEADSTORE accounts, you can chose one here.', $this->plugin_name);

$title_expert_and_group = __('Chose one of your groups. You can create new ones logging in with your account on https://'.hs_backend::domain, $this->plugin_name);

$title_design = __('Choose one design', $this->plugin_name);

$title_expert_and_group_info = __('It can take a few seconds to load your experts after the account has been chosen.', $this->plugin_name);


?>

<p>
	<span title='<?php echo $title_widget_title;?>'><label for="<?php echo $this->get_field_id(widget_call_me_fields::title); ?>"><?php _e('Widget Title:', $this->plugin_name); ?></label></span>
	<span title='<?php echo $title_widget_title;?>'><input id='<?php echo $this->get_field_id(widget_call_me_fields::title); ?>' name="<?php echo $this->get_field_name(widget_call_me_fields::title); ?>" value="<?php echo $instance[widget_call_me_fields::title]; ?>" style="width:100%;" /></span>
</p>
<p>
	<span title='<?php echo $title_username;?>'><label for="<?php echo $this->get_field_id(widget_call_me_fields::username ); ?>"><?php _e('Account:', $this->plugin_name); ?></label> </span>
	<span title='<?php echo $title_username;?>'><select onChange="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id='<?php echo $this->get_field_id(widget_call_me_fields::username ); ?>' name="<?php echo $this->get_field_name(widget_call_me_fields::username); ?>" style="width:100%;" > <?php echo $options_users;?></select> </span>
</p>
<?php 
	/*if(null == $experts_list || !array_key_exists('expertsAndGroups',$experts_list))
	{ 
		?>
		No Call-Me buttons found for this Username.<br />
		Go to <a href="https://<?php echo $this->headstoreBackendSubdomain;?>.headstore.com/#signup">headstore.com</a> to create your first Call-Me button.<br /><br /><br />
	
		<?php
		return;
	}*/
	
	$hasGroups = false;
	$hasButtons = false;
    foreach( $experts_list['expertsAndGroups'] as $expertOrGroup) { 
		$hasButtons = true;
		if ($expertOrGroup['dataFrom']!="INDIVIDUAL_EXPERT") {
	    	$hasGroups = true;
	        break;
		}
		
	}
	//echo('hasGroups='.$hasGroups);
    if(!$hasButtons)
		{ 
			
			?>
		No Call-Me buttons found for this Account.<br />
		Go to <a target="_blank" href="<?php echo hs_backend::domain;?>/">headstore.com</a> to create your first Call-Me button.<br /><br /><br />
	
		<?php
		return;
	}         
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'expertOrGroup' ); ?>"><?php _e($hasGroups?'Expert/Group:':'Expert:'); ?></label>
                <select onChange="document.getElementById('<?php echo $this->get_field_id( 'dataFrom' ); ?>').value=this.options[this.selectedIndex].getAttribute('data-type');document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id='<?php echo $this->get_field_id(widget_call_me_fields::expert ); ?>' name="<?php echo $this->get_field_name(widget_call_me_fields::expert); ?>"  style="width:100%;">
                 
               
				<?php foreach( $experts_list['expertsAndGroups'] as $expertOrGroup) { ?>
                <option data-type="<?php echo $expertOrGroup['dataFrom']; ?>" value="<?php echo $expertOrGroup['webToken']; ?>" <?php  if($instance[widget_call_me_fields::expert] == $expertOrGroup['webToken'] ){echo "selected";}?>>
		<?php echo ($hasGroups?(($expertOrGroup['dataFrom']=="INDIVIDUAL_EXPERT"?"Expert":"Group").": "):"").$expertOrGroup['shortDescription']; ?></option>
                <?php } ?>
                </select>  
			<input type="hidden" id="<?php echo $this->get_field_id( 'dataFrom' ); ?>" name="<?php echo $this->get_field_name( 'dataFrom' ); ?>" value="<?php echo $instance['username']; ?>">
            </p>   		
            <?php
	
	foreach( $experts_list['params'] as $params) { 
	
		
		if($params['type'] == "SELECT_FROM_CMB_PROPERTY")
		{
			
			?>
			<label for="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>"><?php _e($params['label']); ?>:</label>
                    
                    <select onChange="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>" 
                    name="<?php echo $this->get_field_name('embed_params_array').'['.$params['name'].']'; ?>" style="width:100%;">
                    <?php 
			foreach( $experts_list['expertsAndGroups'] as $expertOrGroup2) 
			{  
				if($instance[widget_call_me_fields::expert] == $expertOrGroup2['webToken'])
				{ 
				
				if(!in_array($instance['embed_params_array'][$params['name']],$expertOrGroup2[$params['icmbpropertyName']]))
				{
					$select_option2 = $instance['embed_params_array'][$params['name']];
					?>
					<option value="<?php echo $select_option2; ?>" <?php if($instance['embed_params_array'][$params['name']] == $select_option2)
					{echo "selected";}?>><?php echo $select_option2; ?></option>
					<?php
				}
				
				foreach( $expertOrGroup2[$params['icmbpropertyName']] as $select_option) 
				{ 
					?>
					<option value="<?php echo $select_option; ?>" <?php if($instance['embed_params_array'][$params['name']] == $select_option)
					{echo "selected";}?>><?php echo $select_option; ?></option>
					<?php
				}
				}
			} 
			?>
                    </select> 
                    <input  onBlur="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'].'2' ); ?>" 
                    name="<?php echo $this->get_field_name('embed_params_array').'['.$params['name'].'2]'; ?>"
                    value="<?php echo ""; ?>" style="width:100%;" />
                	<?php	
		}
		elseif($params['type'] == "SELECT")
		{
			?>
                    
                    <label for="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>"><?php _e($params['label']); ?>:</label>
                    
                    <select onChange="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>" 
                    name="<?php echo $this->get_field_name('embed_params_array').'['.$params['name'].']'; ?>" style="width:100%;">
                    <?php 
			foreach( $params['options'] as $select_option) 
			{ 
				$select_option_pack = explode(":", $select_option);
				
				echo "selected? ". $instance['embed_params_array'][$params['name']]." == ".$select_option_pack[0];
				?>
				<option value="<?php echo $select_option_pack[0]; ?>" <?php if($instance['embed_params_array'][$params['name']] == $select_option_pack[0])
				{echo "selected";}?>><?php if(isset($select_option_pack[1])){ echo $select_option_pack[1]; }else{ echo $select_option_pack[0]; } ?></option>
				<?php
			} 
			?>
                    </select> 
                    <?php
			
		}
		elseif($params['type'] == "INPUT")
		{
			?>
			<label for="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>"><?php _e($params['label']); ?>:</label>
                    <input onBlur="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>" 
                    name="<?php echo $this->get_field_name('embed_params_array').'['.$params['name'].']'; ?>"
                    value="<?php echo $instance['embed_params_array'][$params['name']]; ?>" style="width:100%;" />
                    <?php
		}
		elseif($params['type'] == "CHECKBOX")
		{
			?>
                    <label onClick="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" for="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>"><?php _e($params['label']); ?>:</label>
					<br />
                    <input onClick="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" class="checkbox" type="checkbox" <?php if($instance['embed_params_array'][$params['name']] == true){echo"checked";} ?> 
                    id="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>" 
                    name="<?php echo $this->get_field_name('embed_params_array').'['.$params['name'].']'; ?>" /> 
			<?php
		}
		
		?><br /><br /><?php
		
	}
	//Display the preview 	
	$div_params = '';
	foreach( $instance['embed_params_array'] as $key2 => $value2) {
		if($value2 != "")
		{
		$div_params .= '&'.$key2.'='.$value2;
		}
	}
	
	echo '<iframe src="https://'.hs_backend::domain.'/callme/?dataFrom='.$instance[widget_call_me_fields::type].'&preview=1&type=SINGLE_EXPERT&'.($instance[widget_call_me_fields::type]=="COMPANY_GROUP"?"groupId":"expertId").'='.$instance[widget_call_me_fields::expert].$div_params.'" width="210" height="300px" frameborder="0" id="ext-gen1496" se-id="uxiframe-0_0"></iframe>';
	
?>

<!-- Form Here! -->

<!--


<p>
	<span title='<?php echo $title_campaign;?>'><label for="<?php echo $this->get_field_id(widget_call_me_fields::campaign); ?>"><?php _e('Give your "Call-Me Button" an identifier (optional):', $this->plugin_name); ?></label></span>
	<span title='<?php echo $title_campaign;?>'>
	  <input id='<?php echo $this->get_field_id(widget_call_me_fields::campaign); ?>' name="<?php echo $this->get_field_name(widget_call_me_fields::campaign); ?>" value="<?php echo $instance[widget_call_me_fields::campaign]; ?>" style="width:100%;" />
    </span>
</p>

<p>
	<span title='<?php echo $title_expert_and_group;?>'>
		<label for="<?php echo $this->get_field_id(widget_call_me_fields::expert ); ?>"><?php _e('Expert and group :', $this->plugin_name); ?></label><br>
	 <label class="hs-subinfo"><?php echo $title_expert_and_group_info;?></label>
	</span>
	<span title='<?php echo $title_expert_and_group;?>'>
	<select id='<?php echo $this->get_field_id(widget_call_me_fields::expert ); ?>' name="<?php echo $this->get_field_name(widget_call_me_fields::expert); ?>" style="width:100%;" ><?php echo $options_experts_list;?></select>
	</span>
</p>

<p>
	<span title='<?php echo $title_design;?>'><label for="<?php echo $this->get_field_id(widget_call_me_fields::design ); ?>"><?php _e('Design:', $this->plugin_name); ?></label></span> <br>
	<span title='<?php echo $title_design;?>'>
		<input type="radio" name="<?php echo $this->get_field_name(widget_call_me_fields::design); ?>" value="1" <?php if($instance[widget_call_me_fields::design] == 1) echo 'checked'; ?>>1   <br>
	    <input type="radio" name="<?php echo $this->get_field_name(widget_call_me_fields::design); ?>" value="2" <?php if($instance[widget_call_me_fields::design] == 2) echo 'checked'; ?>>2  <br>
	    <input type="radio" name="<?php echo $this->get_field_name(widget_call_me_fields::design); ?>" value="3" <?php if($instance[widget_call_me_fields::design] == 3) echo 'checked'; ?>>3 <br>
	</span>
</p>
-->
 <input type="hidden" id='<?php echo $this->get_field_id(widget_call_me_fields::type ); ?>' name="<?php echo $this->get_field_name(widget_call_me_fields::type); ?>"  value="">
<?php echo $hiddens;?>