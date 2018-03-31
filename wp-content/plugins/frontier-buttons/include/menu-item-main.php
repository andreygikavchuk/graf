<?php
/*
Main menu - Frontier  Buttons
*/


function fbut_main_settings($fbut_module)
	{
	global $wp_version, $tinymce_version;
	
	$fbut_editor_types 			= array('full' => __('Full Editor', 'frontier-buttons'), 'teeny' => __('Visual simple', 'frontier-buttons'), 'quicktags' => __('Quicktags', 'frontier-buttons'));

	
	// load settings
	$bsettings			= get_option(FBUT_SETTINGS_NAME, array());
	
	
	echo '<form name="frontier_buttons_settings" method="post" action="">';
	echo '<input type="hidden" name="menu_item" value="'.$fbut_module.'"></input>';
	
	//echo "** TEST **";
	
	echo '<table class="frontier-buttons-settings-main">';
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Load additional tinymce plugins", "frontier-buttons").'</td>';
		echo '<td class="frontier-buttons-settings-value">';
		echo '<input type="checkbox" name="load_fbuttons_plugins" value="true"'.( fbut_bool($bsettings["load_fbuttons_plugins"]) ? "checked" : "" ).'></input>';
		echo ' <div class="frontier-buttons-info">'.__("Enable: Table, Search/Replace, Preview plugins (and Code sample if wp version >4.5)", "frontier-buttons").'</div>';  
		echo '</td>';
	
	
	echo '<tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Enable editor for comments", "frontier-buttons").'</td>';	
		echo '<td class="frontier-buttons-settings-value">';
		echo '<input type="checkbox" name="comment_editor_enable" value="true"'.( fbut_bool($bsettings["comment_editor_enable"]) ? "checked" : "" ).'></input>';
		echo ' <div class="frontier-buttons-info">'.__("Enable control of configurable editors for comments ", "frontier-buttons").'</div>';  
		echo '</td>';
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Enable fix for comment reply", "frontier-buttons").'</td>';
		echo '<td class="frontier-buttons-settings-value">';
		echo '<input type="checkbox" name="comment_editor_fix" value="true"'.( fbut_bool($bsettings["comment_editor_fix"]) ? "checked" : "" ).'></input>';
		echo ' <div class="frontier-buttons-info">'.__("Fixes issue with custom comments editor not working for nested comments", "frontier-buttons").'</div>'; 
		echo '</td>';
	
		echo '</tr><tr>';
			echo '<td class="frontier-buttons-settings-label">'.__("Load Prism code styling in Frontend", "frontier-buttons").'</td>';
			echo '<td class="frontier-buttons-settings-value">';
			echo '<input type="checkbox" name="load_prism_frontend" value="true"'.( fbut_bool($bsettings["load_prism_frontend"]) ? "checked" : "" ).'></input>';
			echo '</td>';
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Editor lines for comments", "frontier-buttons").'</td>';
		echo '<td class="frontier-buttons-settings-value">';
		echo '<input type="text" name="comment_editor_lines" value="'.intval($bsettings["comment_editor_lines"]).'"</td>';
		echo '</td>';
	
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Add text to buttons in settings", "frontier-buttons").'</td>';
		echo '<td class="frontier-buttons-settings-value">';
		echo '<input type="checkbox" name="add_text_to_buttons" value="true"'.( fbut_bool($bsettings["add_text_to_buttons"]) ? "checked" : "" ).'></input>';
		echo ' <div class="frontier-buttons-info">'.__("Adds button name next to icon, this is only here and not when editor is displayed", "frontier-buttons").'</div>'; 
		echo '</td>';
	
	
		
	
	$new_detected 	= false;
	$new_names		= array();
	foreach ($bsettings['detected_buttons'] as $button_id => $status)
		{
		if ( array_key_exists('status', $status) && $status['status'] == "new" )
			{
			$new_detected 	= true;
			$new_names[]	= $button_id;
			}
		}
	
	if ($new_detected)
		{
		echo '</tr><tr>';
			echo '<td class="frontier-buttons-settings-detected" colspan="2">* '.__("New buttons detected", "frontier-buttons");
			echo ': '.implode($new_names, ', ');
			echo '</td>';
		}	
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Enable Role based editors", "frontier-buttons").'</td>';
		echo '<td class="frontier-buttons-settings-value">';
		echo '<input type="checkbox" name="use_role_editors" value="true"'.( fbut_bool($bsettings["use_role_editors"]) ? "checked" : "" ).'></input>';
		echo ' <div class="frontier-buttons-info">'.__("Below display of editors changes when setting is saved", "frontier-buttons").'</div>';
		echo '</td>';
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label colspan="2"">&nbsp;</td>';
	
	
	//echo 'Wordpress version: '.$wp_version.'  -  TinyMCE version: '.$tinymce_version.'<br>';
	
	if ( !fbut_bool($bsettings["use_role_editors"]) )
		{
		
		$editor_list	= fbut_editor_list();
		echo '</tr><tr>';
			echo '<td class="frontier-buttons-settings-label">'.__("Editor", "frontier-buttons").'</td>';
			echo '<td class="frontier-buttons-settings-value">';
			echo '<select name="std_editor" >';
				foreach($editor_list as $id => $desc) :    
					echo '<option value="'.$id.'" ';
					if ( $id == $bsettings["std_editor"] )
						echo 'selected="selected"';
					echo '>'.$desc.'</option>';
				endforeach;
				echo '</select>';
			echo '</td>';
		
		$editor_list	= fbut_cmt_editor_list();	
		echo '</tr><tr>';
			echo '<td class="frontier-buttons-settings-label">'.__("Comment Editor", "frontier-buttons").'</td>';
			echo '<td class="frontier-buttons-settings-value">';
			echo '<select name="std_cmt_editor" >';
				foreach($editor_list as $id => $desc) :    
					echo '<option value="'.$id.'" ';
					if ( $id == $bsettings["std_cmt_editor"] )
						echo 'selected="selected"';
					echo '>'.$desc.'</option>';
				endforeach;
				echo '</select>';
			echo '</td>';
				
		}
	
	echo '</tr>';
	echo '</table>';
	
	//*******************************************************************************************************
	// Editor assignment per role
	//*******************************************************************************************************
	
	if ( fbut_bool($bsettings["use_role_editors"]) )
		{
		
		$role_caps 		=  fbut_roles_caps();
		$collum 		= array('role' => __("Role", "frontier-buttons"))+fbut_role_editor_types()+array( 'capability' => __("Capability", "frontier-buttons") );
		$role_editors	= fbut_get_default_role_editors($bsettings['role_editors']);
	
		//echo "role editors<pre>".print_r($role_editors, true)."</pre>";
	
		echo '<br>';
		echo '<table class="frontier-buttons-settings-editors">';
		echo '<tr>';
	
	
		foreach ($collum as $key => $value)
			{
			echo '<td class="frontier-buttons-table-heading">'.$value.'</td>';
			}
		echo '</tr>';
	
	
		foreach ($role_caps as $cap => $role)
			{
			echo '<tr>';
		
			foreach ($collum as $key => $value)
				{
				echo '<td class="frontier-buttons-settings-editors">';
	
			
				if ($key == 'role' )
					{
					echo $role;
					}
	
				if ($key == 'capability' )
					{
					echo $cap;
					}
	
	
				if ($key == 'default_editor' || $key == 'cmt_editor' )
					{
					if ($key == 'cmt_editor')
						{
						$editor_list			= fbut_cmt_editor_list();
						}
					else
						{
						$editor_list			= fbut_editor_list();
						}
				
					//$default_list 			= fbut_default_editor_list();
					//$set_editors			= $bsettings['cap_editor_list'];
					//echo "<pre>".print_r($set_editors, true)."</pre>";
					//$editor = array_key_exists($cap, $set_editors) ? $set_editors[$cap] : FBUT_BASIC_EDITOR;
					//echo '<tr><td class="frontier-buttons-settings-role">';
					//echo "Editor: ".$editor."<br>";

					$editor = $role_editors[$cap][$key];
		
					echo '<select name="'.$cap.'_'.$key.'" >';
					foreach($editor_list as $id => $desc) :    
						echo '<option value="'.$id.'" ';
						if ( $id == $editor )
							echo 'selected="selected"';
						echo '>'.$desc.'</option>';
					endforeach;
					echo '</select>';
		
				
					} // end if editor 
			
				echo '</td>';
				} // end columns
			
				echo '</tr>';
			} // end role caps 		
			
		
		
		echo '</table>';
	} // end if role caps		
		
	
	
	echo '<br>';
	echo '<button class="button frontier-buttons-submit" type="submit" name="frontier-buttons-submit" id="frontier-buttons-submit" value="'.$fbut_module.'">Save</button>';	
	echo '<br><br>';
	
	echo '<table class="frontier-buttons-settings-main">';
	
	echo '<tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Last frontend detection", "frontier-buttons").': </td>';
		echo '<td class="frontier-buttons-settings-label">'.date("Y-m-d H:i", $bsettings['last_frontend_detect']);
		echo ' - '.__("Force extra button check for backend", "frontier-buttons").': ';
		echo '<input type="checkbox" name="force_backend_check" value="true"'.( fbut_bool($bsettings["force_backend_check"]) ? "checked" : "" ).'></input>';
		echo '</td>';
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Last backend detection", "frontier-buttons").': </td>';
		echo '<td class="frontier-buttons-settings-label">'.date("Y-m-d H:i", $bsettings['last_backend_detect']);
		echo ' - '.__("Force extra button check for frontend", "frontier-buttons").': ';
		echo '<input type="checkbox" name="force_frontend_check" value="true"'.( fbut_bool($bsettings["force_frontend_check"]) ? "checked" : "" ).'></input>';
		echo '</td>';
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label" colspan="2">';
		echo ' <div class="frontier-buttons-info">*'.__("Extra buttons are checked every ", "frontier-buttons");
		echo (fbut_detect_interval()/60);
		echo ' '.__("minutes ", "frontier-buttons");
		echo ' - '.__("Force check will force check on next display of editor", "frontier-buttons").'</div>';
		echo '</td>';
	
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">&nbsp;</td>';
		echo '<td class="frontier-buttons-settings-label">&nbsp;</td>';
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Frontier Buttons version", "frontier-buttons").'</td>';
		echo '<td class="frontier-buttons-settings-label">'.FRONTIER_BUTTONS_VERSION.'</td>';
	
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("Wordpress version", "frontier-buttons").'</td>';
		echo '<td class="frontier-buttons-settings-label">'.$wp_version.'</td>';
		
	echo '</tr><tr>';
		echo '<td class="frontier-buttons-settings-label">'.__("tinymce version", "frontier-buttons").'</td>';
		echo '<td class="frontier-buttons-settings-label">'.$tinymce_version.' ('.fbut_tinymce_plugin_version().')	</td>';
		
	
	
	echo '</tr>';
	echo '</table>';
	
	echo '</form>';
	} //function fbut_main_settings
			

	
	?>