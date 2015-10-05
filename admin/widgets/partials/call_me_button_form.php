<?php

$title_campaign = __('If you have multiple "Call-Me Buttons" the Campaign ID lets you identify which one is in use. For example if you use the same button on several sites, you can determine which site the call came from.', $this->plugin_name);

$title_widget_title = __('This title will appear above your "Call-Me Button".', $this->plugin_name);

$title_username = __('If you have multiple HEADSTORE accounts, you can chose one here.', $this->plugin_name);

$title_expert_and_group = __('Chose one of your groups. You can create new ones logging in with your account on https://app.headstore.com', $this->plugin_name);

$title_design = __('Chose one design', $this->plugin_name);

$title_expert_and_group_info = __('It can take a few seconds to load your experts after the account has been chosen.', $this->plugin_name);

?>

<p>
	<span title='<?php echo $title_widget_title;?>'><label for="<?php echo $this->get_field_id(widge_call_me_fields::title); ?>"><?php _e('Widget Title:', $this->plugin_name); ?></label></span>
	<span title='<?php echo $title_widget_title;?>'><input id='<?php echo $this->get_field_id(widge_call_me_fields::title); ?>' name="<?php echo $this->get_field_name(widge_call_me_fields::title); ?>" value="<?php echo $instance[widge_call_me_fields::title]; ?>" style="width:100%;" /></span>
</p>

<p>
	<span title='<?php echo $title_username;?>'><label for="<?php echo $this->get_field_id(widge_call_me_fields::username ); ?>"><?php _e('Account:', $this->plugin_name); ?></label> </span>
	<span title='<?php echo $title_username;?>'><select id='<?php echo $this->get_field_id(widge_call_me_fields::username ); ?>' name="<?php echo $this->get_field_name(widge_call_me_fields::username); ?>" style="width:100%;" > <?php echo $options_users;?></select> </span>
</p>

<p>
	<span title='<?php echo $title_campaign;?>'><label for="<?php echo $this->get_field_id(widge_call_me_fields::campaign); ?>"><?php _e('Give your "Call-Me Button" an identifier (optional):', $this->plugin_name); ?></label></span>
	<span title='<?php echo $title_campaign;?>'>
	  <input id='<?php echo $this->get_field_id(widge_call_me_fields::campaign); ?>' name="<?php echo $this->get_field_name(widge_call_me_fields::campaign); ?>" value="<?php echo $instance[widge_call_me_fields::campaign]; ?>" style="width:100%;" />
    </span>
</p>

<p>
	<span title='<?php echo $title_expert_and_group;?>'>
		<label for="<?php echo $this->get_field_id(widge_call_me_fields::expert ); ?>"><?php _e('Expert and group :', $this->plugin_name); ?></label><br>
		<label class="hs-subinfo"><?php echo $title_expert_and_group_info;?></label>
	</span>
	<span title='<?php echo $title_expert_and_group;?>'>
	<select id='<?php echo $this->get_field_id(widge_call_me_fields::expert ); ?>' name="<?php echo $this->get_field_name(widge_call_me_fields::expert); ?>" style="width:100%;" ><?php echo $options_experts_list;?></select>
	</span>
</p>

<p>
	<span title='<?php echo $title_design;?>'><label for="<?php echo $this->get_field_id(widge_call_me_fields::design ); ?>"><?php _e('Design:', $this->plugin_name); ?></label></span> <br>
	<span title='<?php echo $title_design;?>'>
		<input type="radio" name="<?php echo $this->get_field_name(widge_call_me_fields::design); ?>" value="1" <?php if($instance[widge_call_me_fields::design] == 1) echo 'checked'; ?>>1   <br>
	    <input type="radio" name="<?php echo $this->get_field_name(widge_call_me_fields::design); ?>" value="2" <?php if($instance[widge_call_me_fields::design] == 2) echo 'checked'; ?>>2  <br>
	    <input type="radio" name="<?php echo $this->get_field_name(widge_call_me_fields::design); ?>" value="3" <?php if($instance[widge_call_me_fields::design] == 3) echo 'checked'; ?>>3 <br>
	</span>
</p>
 <input type="hidden" id='<?php echo $this->get_field_id(widge_call_me_fields::type ); ?>' name="<?php echo $this->get_field_name(widge_call_me_fields::type); ?>"  value="">
<?php echo $hiddens;?>