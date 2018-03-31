<?php


//**********************************************************************************
// Check upgrade
//**********************************************************************************

function frontier_buttons_upgrade_check()
	{
	//error_log("Before upgrade");
	if ( is_admin()  )
		{
		//delete_option(FBUT_SETTINGS_NAME);
	
		$bsettings			= get_option(FBUT_SETTINGS_NAME, array() );
	
		// ********* TEST ************
		//$bsettings = array();
	
		$fbut_last_upgrade 	= array_key_exists("fbut_last_upgrade", $bsettings) ? $bsettings["fbut_last_upgrade"] : '0.0.0';

		//echo "<br>Before upgrade<br>";

		//**********************************************************************************
		// Check pre version 2.0 upgrade
		//**********************************************************************************

		
		if ( !array_key_exists('pre_two_upgrade', $bsettings) ) 
			{
			$old_settings 	= get_option("frontier_buttons_settings", array());
			$old_toolbars 	= get_option("frontier_buttons_toolbars", array());
			
			$bsettings['pre_two_upgrade'] 	= true;	
			
			if ( count($old_settings) > 1 )
				{
				
				$bsettings['use_role_editors']		= false;
			
				$bsettings['comment_editor_enable'] = fbut_bool($old_settings['enable_comment_editor']);
				$bsettings['comment_editor_fix'] 	= fbut_bool($old_settings['comment_editor_fix']);
			
				// set toolbars
				$fbut_toolbars	= fbut_default_toolbars();
			
				if ( !array_key_exists(FBUT_STANDARD_EDITOR, $bsettings) )
					$bsettings[FBUT_STANDARD_EDITOR] = array();
				
				$bsettings[FBUT_STANDARD_EDITOR]['toolbar1']	= ( isset($old_toolbars[0]) ? $old_toolbars[0] : $fbut_toolbars[FBUT_STANDARD_EDITOR]['toolbar1'] );
				$bsettings[FBUT_STANDARD_EDITOR]['toolbar2']	= ( isset($old_toolbars[1]) ? $old_toolbars[1] : $fbut_toolbars[FBUT_STANDARD_EDITOR]['toolbar2'] );
				$bsettings[FBUT_STANDARD_EDITOR]['toolbar3']	= ( isset($old_toolbars[2]) ? $old_toolbars[2] : $fbut_toolbars[FBUT_STANDARD_EDITOR]['toolbar3'] );
				$bsettings[FBUT_STANDARD_EDITOR]['toolbar4']	= ( isset($old_toolbars[3]) ? $old_toolbars[3] : $fbut_toolbars[FBUT_STANDARD_EDITOR]['toolbar3'] );
			
				if ( !array_key_exists(FBUT_WP_TEENY_EDITOR, $bsettings) )
					$bsettings[FBUT_WP_TEENY_EDITOR] = array();
			
				$bsettings[FBUT_WP_TEENY_EDITOR]['toolbar1']	= ( isset($old_toolbars[4]) ? $old_toolbars[4] : $fbut_toolbars[FBUT_WP_TEENY_EDITOR]['toolbar1'] );
			
				update_option(FBUT_SETTINGS_NAME, $bsettings);
				
				//delete_option("frontier_buttons_settings");
			
				// Put an settings updated message on the screen
				add_action('admin_notices', 'fbut_upgrade_old_notice');
				function fbut_upgrade_old_notice()
					{
					echo '<div class="updated"><p><strong>Plugin: Frontier Buttons settings migrated from pre version 2.0  - Please review settings</strong></p></div>';
					}
				}
			} // V 2 upgrade			
		//**********************************************************************************
		// Normal version update to capture new settings etc
		//**********************************************************************************
	
		if ( version_compare(FRONTIER_BUTTONS_VERSION, $fbut_last_upgrade, '>' ) )
			{
			
			//$tmp_wp_buttons 		= fbut_wp_std_buttons();
			$fbut_standard_settings = fbut_default_settings();
			foreach($fbut_standard_settings as $tmp_option_name => $tmp_default_value )
				{
				if ( !key_exists($tmp_option_name, $bsettings) )
					{
					$bsettings[$tmp_option_name] = $tmp_default_value;	
					}
		
				}
		
			// set default rolebased editors
			if (!array_key_exists('role_editors', $bsettings))
				$bsettings['role_editors'] = array();
			
			$bsettings['role_editors']	= fbut_get_default_role_editors( $bsettings['role_editors'] );
		
		
			// check default toolbars
			$default_toolbars		= fbut_default_toolbars();
			foreach (fbut_default_toolbars() as $key => $value)
				{
				if ( !array_key_exists($key, $bsettings) )
					$bsettings[$key] = $value;
				}
		
			$bsettings['fbut_last_upgrade']	= FRONTIER_BUTTONS_VERSION;
		
		
		
			//$bsettings['all_buttons'] 		= $tmp_wp_buttons['all_buttons'];
		
			update_option(FBUT_SETTINGS_NAME, $bsettings);
		
			// Put an settings updated message on the screen
			add_action('admin_notices', 'fbut_upgrade_notice');
			function fbut_upgrade_notice()
				{
				echo '<div class="updated"><p><strong>Plugin: FrontierButtons activated/upgraded version: '.FRONTIER_BUTTONS_VERSION.' - Please review settings</strong></p></div>';
				}
		
		
			//error_log("**** Frontier Buttons Settings upgrade ***");
			//error_log(print_r($bsettings, true));
		
			}
		
		}
	} // end upgrade check

?>