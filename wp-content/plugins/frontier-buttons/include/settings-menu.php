<?php
/*
Admin settings menu - Frontier  Buttons
*/


function fbut_admin_menu() 
	{
	//create new top-level menu
	add_options_page('Frontier-Buttons', 'Frontier-Buttons', 'manage_options', __FILE__, 'fbut_admin_settings');
	}

			

function fbut_admin_settings() 
	{
	//$defaults_file = FBUT_PLUGIN_DIR."/frontier-buttons-defaults.php";
	//echo "Set file: ".$defaults_file."<br>";
	//include(FBUT_PLUGIN_DIR."/frontier-buttons-defaults.php");
	//must check that the user has the required capability 
	
	if (!current_user_can('manage_options'))
		{
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
	
	

	
	
	//include(FBUT_PLUGIN_DIR."/frontier-buttons-defaults.php");
	
	$fbut_editors = fbut_editor_types();
		
	$fbut_menu_items	= Array("main" => __("Main Settings", "frontier-buttons") )+$fbut_editors+array( "extra_buttons" => __("Extra Buttons", "frontier-buttons") );
	
	$fbut_module = isset($_GET["menu_item"]) ? $_GET["menu_item"] : "main";
	
	$setting_menu_link = esc_url( get_admin_url(null, 'options-general.php?page=frontier-buttons/include/settings-menu.php') );

	$bsettings			= get_option(FBUT_SETTINGS_NAME, array() );
	
	// ***TESTING***
	/*
	if (isset($_POST))
		{
		error_log("*** $_POST ***");
		error_log(print_r($_POST, true));
		//error_log("*** Settings ***");
		//error_log(print_r($bsettings, true));
		
		}
	*/	
	
	

	
	
	
	// See if the user has pressed save
	if( isset($_POST["frontier-buttons-submit"]) && array_key_exists($_POST[ "frontier-buttons-submit" ],$fbut_menu_items) ) 
		{
		$save_menu_item = $_POST[ "frontier-buttons-submit" ];
		$bsettings		= get_option(FBUT_SETTINGS_NAME, array() );
	
		//save main settings
		if ( $save_menu_item == "main" )
			{
			$fbut_standard_settings = fbut_default_settings();
			$fields_bool 			= fbut_bool_settings();
		
			foreach ($fbut_standard_settings as $key => $value)
				{
				if ( array_key_exists($key, $_POST) )
					{
					$bsettings[$key] = $_POST[$key];
					}
				else
					{
					if ( in_array($key, $fields_bool)  )
						$bsettings[$key] = false;
					}
				}
			// make sure editor lines is an integer
			$bsettings["comment_editor_lines"] = intval($bsettings["comment_editor_lines"]);
			
			$role_editors	= $bsettings['role_editors'];
	
			// get the role editors
			foreach (fbut_roles_caps() as $cap => $role)
				{
				foreach ( fbut_role_editor_types()  as $key => $value)
					{
					$field_name = $cap."_".$key;
					if ( isset($_POST[$field_name]) )
						{
						$role_editors[$cap][$key] = $_POST[$field_name];
						//echo $field_name." = ".$_POST[$field_name]."<br>";
						}
					}
				}
			$bsettings['role_editors'] = $role_editors;
			
			
			update_option(FBUT_SETTINGS_NAME, $bsettings);
			// Put an settings updated message on the screen
			echo '<div class="updated"><p><strong>'.__('Settings saved.', 'frontier-buttons' ).'</strong></p></div>';
		
			} // end main
		
		//save extra buttons
		if ( $save_menu_item == "extra_buttons" )
			{
			$extra_button_choice		= fbut_extra_button_choice();
			$detected_buttons 			= $bsettings['detected_buttons'];
			
			// first reset extra buttons
			$bsettings['extra_buttons'] = array();
			//echo "<pre>".print_r($_POST, true)."</pre>";
			foreach ($detected_buttons as $key => $value)
				{
				$set = $_POST['extra_button_status_'.$key];				
				$detected_buttons[$key]['status'] = $set;
				if ($set == 'delete')
					unset($detected_buttons[$key]);
				
				if ($set == 'add')
					$bsettings['extra_buttons'][] = $key;
				}
			
			$bsettings['detected_buttons'] = $detected_buttons;
			update_option(FBUT_SETTINGS_NAME, $bsettings);
			echo '<div class="updated"><p><strong>'.__('Extra buttons saved.', 'frontier-buttons' ).'</strong></p></div>';
		
			}	// end extra buttons	
		
		//save editor toolbars settings
		if ( array_key_exists($save_menu_item, $fbut_editors) )
			{
			// we need to get the 4 toolbars
			$tmp_toolbars = array();
			for ($i = 1; $i <= 4; $i++) 
				{
				$toolbar_name = "toolbar".$i;
				$dropzone_name = "toolbar".$i;
				
				if ( isset($_POST[$toolbar_name]) )
					$tmp_toolbars[$toolbar_name] = json_decode(str_replace("\\", "",$_POST[$dropzone_name]));
				else
					$tmp_toolbars[$toolbar_name]= array();
				
				
				} 

			$bsettings[$save_menu_item] = $tmp_toolbars;
			update_option(FBUT_SETTINGS_NAME, $bsettings);
			echo '<div class="updated"><p><strong>'.__('Editor layout saved.', 'frontier-buttons' ).'</strong></p></div>';
		
			} // save toolbar
		
		// set all buttons and save
		//$tmp_wp_buttons 			= fbut_wp_std_buttons();
		//$bsettings['all_buttons'] = $tmp_wp_buttons['all_buttons'];
		//update_option(FBUT_SETTINGS_NAME, $bsettings);
			
		}
	
	// See if the user has pressed reset buttons
	if( isset($_POST["frontier-buttons-reset"]) && array_key_exists($_POST[ "frontier-buttons-reset" ],$fbut_menu_items) ) 
		{
		$save_menu_item = $_POST[ "frontier-buttons-reset" ];
		//save editor toolbars settings
		if ( array_key_exists($save_menu_item, $fbut_editors) )
			{
			$bsettings		= get_option(FBUT_SETTINGS_NAME, array() );
			$default_toolbars		= fbut_default_toolbars();
			if ( array_key_exists($save_menu_item, $default_toolbars) )	
				{
				$bsettings[$save_menu_item] = $default_toolbars[$save_menu_item];
				update_option(FBUT_SETTINGS_NAME, $bsettings);
				echo '<div class="updated"><p><strong>'.__('Toolbars reset to default and saved', 'frontier-buttons' ).'</strong></p></div>';
				}
			} // save toolbar
		} // end reset toolbar
	
	//*************************************************************************
	// Settings page
	//*************************************************************************
	
	$bsettings			= get_option(FBUT_SETTINGS_NAME, array() );
	
	echo '<div id="frontier-buttons-settings-menu">';
	//echo '<div class="frontier-admin-menu">';
	echo '<h3>'.__("Frontier Buttons Settings", "frontier-buttons").'</h3>';
	
	echo '<table class="frontier-buttons-main-table">';
	echo '<tr>';
		echo '<td class="frontier-buttons-left-column">';
			// ** Menu **
			echo '<table class="frontier-buttons-setting-menu">';
			foreach ($fbut_menu_items as $key => $value)
				{
				
				echo '<tr>';
				if ($key == $fbut_module)
					$selected_class = 'frontier-buttons-menu-item-selected';
				else
					$selected_class = '';
				
					echo '<td class="frontier-buttons-menu-item '.$selected_class.'">';
						$tmp_link = $setting_menu_link."&menu_item=".$key;
						echo '<a class="frontier-buttons-menu-link '.$selected_class.'" href="'.$tmp_link.'">'.$value.'</a>';
					echo '</td>';
				
				echo '</tr>';
				
				}
			echo '</table>';	
			
			
		echo '</td>';
		
		
		echo '<td class="frontier-buttons-right-column">';
			//echo '<h2 class="frontier-buttons-heading frontier-buttons-heading_'.$fbut_module.'">'.$fbut_menu_items[$fbut_module].'</h2>';
			
			



			
			if ( $fbut_module == "main" )
				{
				include(FBUT_PLUGIN_DIR."/include/menu-item-main.php");
				fbut_main_settings($fbut_module);
				}
			if ( $fbut_module == "extra_buttons" )
				{
				include(FBUT_PLUGIN_DIR."/include/menu-item-extra-buttons.php");
				fbut_menu_extra_buttons($fbut_module);
				}
			
			
			if ( array_key_exists($fbut_module, $fbut_editors) )
				{
				include(FBUT_PLUGIN_DIR."/include/menu-item-editors.php");
				fbut_menu_editor($fbut_module);
				}
		
			//echo '</fieldset>';
			
		echo '</td>';
	echo '</tr>';
	echo '</table>';
	
	// ************** Show the editor *******************************************
	/*
	echo '<table class="frontier-buttons-editor-table">';
	echo '<tr>';
		echo '<td class="frontier-buttons-show-editor" colspan="2">';
			echo __("Sample editor", "frontier-buttons").":";
			$tmp_text = __("This is a sample of the editor, new button layout wont show until you save","frontier-buttons") . " <br>	:)  <br>";
			$editor_layout	= array('media_buttons' => false, 'dfw' => false, 'tabfocus_elements' => 'sample-permalink,post-preview', 'editor_height' => 100 );
			wp_editor($tmp_text, 'frontier_buttons', $editor_layout);
		echo '</td>';
	echo '</tr>';		
	echo '</table">';
	*/
	
	if ( array_key_exists($fbut_module, $fbut_editors) )
		$editor_id = $fbut_module;
	else	
		$editor_id = "standard_editor";
	
	$editor_types = fbut_editor_types();
	$editor_name = $editor_types[$editor_id];
	echo '<fieldset class="frontier-buttons-sample-editor"><legend>'.$editor_name.'</legend>';
		$tmp_text = __("This is a sample of the editor, new button layout wont show until you save","frontier-buttons") . " <br>	:)  <br>";
		$editor_layout	= array('media_buttons' => false, 'dfw' => false, 'tabfocus_elements' => 'sample-permalink,post-preview', 'editor_height' => 100 );
		
		wp_editor($tmp_text, 'frontier_buttons_'.$editor_id, $editor_layout);
				
	echo '</fieldset>';
	
	// ************** debug info *******************************************
	
	//echo '<hr>';
	
	/*
	echo '<table class="frontier-buttons-debug-table">';
	echo '<tr>';
		echo '<td class="frontier-buttons-show-debug" colspan="2">';
		$fbut_extra_buttons = get_option(FBUT_EXTRA_BUTTONS_NAME, array());	
		echo "Settings: <pre>".print_r($fbut_extra_buttons,true)."</pre>";
		echo "</td>";
	echo '</tr>';		
	echo '</table">';
	*/
	
	
	/*
	echo '<table class="frontier-buttons-debug-table">';
	echo '<tr>';
		echo '<td class="frontier-buttons-show-debug" colspan="2">';
		$bsettings		= get_option(FBUT_SETTINGS_NAME, array());	
		echo 'Settings: <pre class="frontier-buttons-show-debug">'.print_r($bsettings,true).'</pre>';
		echo "</td>";
	echo '</tr>';		
	echo '</table">';
	*/
	
	/*
	echo '<table class="frontier-buttons-debug-table">';
	echo '<tr>';
		echo '<td class="frontier-buttons-show-debug" colspan="2">';
		$bsettings		= get_option(FBUT_SETTINGS_NAME, array());	
		echo "Std buttons: <pre>".print_r(fbut_wp_std_buttons(),true)."</pre>";
		echo "</td>";
	echo '</tr>';		
	echo '</table">';
	*/	
		
			
				
		

	echo '</div>';
	} // end function frontier_buttons_settings_page
	
	
	
	
	?>