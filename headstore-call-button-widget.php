<?php
/**
 * Plugin Name: Headstore Call Button Widget
 * Description: A widget that displays the call Button.
 * Version: 0.4
 * Author: 
 	0.1 Kelian Maissen, Headstore AG
 	0.2 Renato Giuliani, Headstore AG
 	0.3 Renato Giuliani, Headstore AG
	0.4 Renato Giuliani, Headstore AG
**/


add_action( 'widgets_init', 'headstore_widget' );


function headstore_widget() {
	register_widget( 'Main_Widget' );
}

class Main_Widget extends WP_Widget {

	var $headstoreBackendSubdomain = 'dev1';

	function Main_Widget() {
		$widget_ops = array( 'classname' => 'headstore', 'description' => __('Add a Headstore Call Button.', 'headstore') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'headstore-widget' );
		
		$this->WP_Widget( 'headstore-widget', __('Headstore Call Button Widget', 'headstore'), $widget_ops, $control_ops );
		
		add_action('wp_enqueue_scripts', array($this, 'add_page_scripts'));
	}
	
	
  function add_page_scripts(){
    if(is_active_widget(false, false, $this->id_base, true)){
      wp_enqueue_script('headstore_script', '//'.$this->headstoreBackendSubdomain.'.headstore.com/callme/callme.js');
    }           
  }

	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		
		echo $before_widget;

		// Display the widget title 
		if ( $title )
		echo $before_title . $title . $after_title;
			
		// params are now atributes of the div tag (allows for more than one buttons on one page) - rg 02-05-2015	
		
		//Display the code 	
		$div_params = '';
		foreach( $instance['embed_params_array'] as $key2 => $value2) {
			if($value2 != "")
			{
			$div_params .= 'data-'.$key2.'"="'.$value2.'" ';
			}
		} 
		
		echo '<div class="callme-button" data-'.($instance['dataFrom']=="COMPANY_GROUP"?"group":"expert").'="'.$instance['expertOrGroup'].'" '.$div_params.'></div>';
	
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	
		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['expertOrGroup'] = strip_tags( $new_instance['expertOrGroup'] );
		$instance['dataFrom'] = strip_tags( $new_instance['dataFrom'] );	
		
		$instance['embed_params_array'] = $new_instance['embed_params_array'];	
		
		
		foreach( $instance['embed_params_array'] as $key => $value) { 
		
			if(array_key_exists($key.'2',$instance['embed_params_array'])) 
			{
				if($instance['embed_params_array'][$key.'2'] != "")
				{
					$instance['embed_params_array'][$key] = $instance['embed_params_array'][$key.'2'];
					$instance['embed_params_array'][$key.'2'] = "";
				}
			}	
		}
		
		return $instance;
	}

	
	function form( $instance ) {
		
		 //Set up some default widget settings.
		$defaults = array( 
		'title' => __('Call Me', 'example'), 
		'username' => __('', 'example'));
		
		
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title:', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>
		
            
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Username:'); ?></label>
				<input onBlur="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" style="width:100%;" />
			</p>
            <?php   
		if($instance['username'] == "")
		{
			?>
           Please enter your Headstore username.<br />
		   If you don't have an account yet, please register at <a href="https://<?php echo $this->headstoreBackendSubdomain;?>.headstore.com/#signup">headstore.com</a> <br /><br /><br />
			<?php
			return;
		}
		else
		{

          
			
			$json = file_get_contents('https://'.$this->headstoreBackendSubdomain.'.headstore.com/api/callme/wp/'.$instance['username'].'/');
			if (!$json) {
				?>
				Username not found .<br />
				If you dont have an account yet, please register at <a href="https://<?php echo $this->headstoreBackendSubdomain;?>.headstore.com/#signup">headstore.com</a> <br /><br /><br />
			
			<?php
				return;
			}
			
			$jsonarray = json_decode($json, true);
	
	
			if(null == $jsonarray || !array_key_exists('expertsAndGroups',$jsonarray))
			{ 
				?>
				No Call-Me buttons found for this Username.<br />
				Go to <a href="https://<?php echo $this->headstoreBackendSubdomain;?>.headstore.com/#signup">headstore.com</a> to create your first Call-Me button.<br /><br /><br />
			
				<?php
				return;
			}
			
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'expertOrGroup' ); ?>"><?php _e('Expert/Group:'); ?></label>
                <select onChange="document.getElementById('<?php echo $this->get_field_id( 'dataFrom' ); ?>').value=this.options[this.selectedIndex].getAttribute('data-from');document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id="<?php echo $this->get_field_id( 'expertOrGroup' ); ?>" name="<?php echo $this->get_field_name( 'expertOrGroup' ); ?>"  style="width:100%;">
                <?php foreach( $jsonarray['expertsAndGroups'] as $expertOrGroup) { ?>
                <option data-from="<?php echo $expertOrGroup['dataFrom']; ?>" value="<?php echo $expertOrGroup['webToken']; ?>" <?php if($instance['expertOrGroup'] == $expertOrGroup['webToken']){echo "selected";}?>>
				<?php echo ($expertOrGroup['dataFrom']=="INDIVIDUAL_EXPERT"?"Expert":"Group").": ".$expertOrGroup['shortDescription']; ?></option>
                <?php } ?>
                </select>  
		<input type="hidden" id="<?php echo $this->get_field_id( 'dataFrom' ); ?>" name="<?php echo $this->get_field_name( 'dataFrom' ); ?>" value="<?php echo $instance['username']; ?>">
            </p>   		
            <?php
			
			foreach( $jsonarray['params'] as $params) { 
			
				
				if($params['type'] == "SELECT_FROM_CMB_PROPERTY")
				{
					
					?>
					<label for="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>"><?php _e($params['label']); ?>:</label>
                    
                    <select onChange="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'] ); ?>" 
                    name="<?php echo $this->get_field_name('embed_params_array').'['.$params['name'].']'; ?>" style="width:100%;">
                    <?php 
					foreach( $jsonarray['expertsAndGroups'] as $expertOrGroup2) 
					{  
						if($instance['expertOrGroup'] == $expertOrGroup2['webToken'])
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
                    <input onBlur="document.getElementById('widget-<?php echo $this->id?>-savewidget').click()" id="<?php echo $this->get_field_id( 'embed_params_array_'.$params['name'].'2' ); ?>" 
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
                    <input class="checkbox" type="checkbox" <?php if($instance['embed_params_array'][$params['name']] == true){echo"checked";} ?> 
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
		
		echo '<iframe src="https://'.$this->headstoreBackendSubdomain.'.headstore.com/callme/?dataFrom='.$instance['dataFrom'].'&preview=1&type=SINGLE_EXPERT&'.($instance['dataFrom']=="COMPANY_GROUP"?"groupId":"expertId").'='.$instance['expertOrGroup'].$div_params.'" width="100%" height="250px" frameborder="0" id="ext-gen1496" se-id="uxiframe-0_0"></iframe>';
	
			 
			
		}
		
	}
}


/*

*/
?>