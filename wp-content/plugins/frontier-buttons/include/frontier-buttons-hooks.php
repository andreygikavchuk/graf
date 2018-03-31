<?php

/*
Frontier Buttons Hooks
*/

//**********************************************************************************
// Set toolbars and Detect new buttons 
//**********************************************************************************


function frontier_buttons_mce_init( $settings, $editor_id  )
	{
	
	// get settings
	$fbut_settings	= get_option(FBUT_SETTINGS_NAME, array());
	
	//error_log("FButtons settings: ".print_r($fbut_settings, true));
	
	// lets get out of here if Frontier Buttons for comments isn't enabled
	if ($editor_id == "comment" && !fbut_bool($fbut_settings['comment_editor_enable']) )
		return $settings;
	
	// a cheat to display editor in frontier buttons settings
	if (strpos($editor_id, 'frontier_buttons_') !== false) 
		{
		$editor_name = substr($editor_id, 17);
		}
	else
		{
		
		if (fbut_bool($fbut_settings['use_role_editors']) )	
			{
			$role = fbut_get_editor_role();
		
			if ($editor_id == "comment")
				$editor_name = $fbut_settings['role_editors'][$role]['cmt_editor'];		
			else
				$editor_name = $fbut_settings['role_editors'][$role]['default_editor'];		
			}
		else
			{
			//error_log("NOT Role editors");
			if ($editor_id == "comment")
				$editor_name = $fbut_settings['std_cmt_editor'];		
			else
				$editor_name = $fbut_settings['std_editor'];		
			
			}
		}
	
	
	//echo "Editor id: ".$editor_id. " - Editor name: ".$editor_name."<br>";
	
	
	if ( $editor_name == FBUT_WP_STANDARD_EDITOR  )
		{
		return $settings;;
		}
	else
		{
		$toolbars = ( array_key_exists($editor_name, $fbut_settings) ? $fbut_settings[$editor_name] : array() );
	
		//**********************************************************************************
		// Detect new buttons before setting toolbars
		//**********************************************************************************

		$detect_interval 	= fbut_detect_interval();
		$do_detection 		= false;
		
		
		if (is_admin())
			{
			if ( fbut_bool($fbut_settings['force_backend_check']) ||  (intval($fbut_settings['last_backend_detect'])+$detect_interval < current_time( 'timestamp')) )
				{
				$fbut_settings['force_backend_check'] = false;
				$fbut_settings['last_backend_detect'] = current_time( 'timestamp');
				$do_detection = true;
				}
			}
		else
			{
			if ( fbut_bool($fbut_settings['force_frontend_check']) ||  (intval($fbut_settings['last_frontend_detect'] )+$detect_interval < current_time( 'timestamp')) )
				{
				$fbut_settings['force_frontend_check'] = false;
				$fbut_settings['last_frontend_detect']  = current_time( 'timestamp');
				$do_detection = true;
				}
			}
			
		if ($do_detection)
			{
			$tmp_used_buttons = array();
			// set toolbar if exists
			for ($i = 1; $i <= 4; $i++) 
				{
				$tid = "toolbar".$i;
		
				// first capture the buttons from the toolbars
				if (strlen($settings[$tid]) > 0)
					{
					$tmp_toolbar = explode(',', $settings[$tid]);
					$tmp_used_buttons = array_merge_recursive($tmp_used_buttons,$tmp_toolbar);
					}
			
		
				// then set the new toolbar
				if ( array_key_exists($tid, $toolbars)  )
					{
					$settings[$tid] = implode($toolbars[$tid], ',');
					}
				} 
	
			$diff = array_diff($tmp_used_buttons, fbut_all_std_buttons());
	
			// save discovered buttons
			if (count($diff) > 0)
				{
				foreach ($diff  as $key => $value)
					{
					if ( $value != "spellchecker" )
						{
						if ( !array_key_exists($value, $fbut_settings['detected_buttons'])   )
							{
							$fbut_settings['detected_buttons'][$value] = array();
							$fbut_settings['detected_buttons'][$value]['status'] = "new";
							}
					
						if ( is_admin() )
							$fbut_settings['detected_buttons'][$value]['backend_discovered'] = date("Y-m-d H:i", current_time( 'timestamp'));
						else
							$fbut_settings['detected_buttons'][$value]['frontend_discovered'] = date("Y-m-d H:i", current_time( 'timestamp'));
				
						}
					//$fbut_settings['detected_buttons'][$value]['frontend_discovered'] = current_time( 'mysql' );
				
					}
				
				}
			update_option(FBUT_SETTINGS_NAME, $fbut_settings);
			} // if detection	
		//**********************************************************************************
		// Set toolbars
		//**********************************************************************************
	
		for ($i = 1; $i <= 4; $i++) 
			{
			$tid = "toolbar".$i;
			if ( array_key_exists($tid, $toolbars)  )
				{
				$settings[$tid] = implode($toolbars[$tid], ',');
				}
			}
		return $settings;
		} // if not standard editor
	
	return $settings;
	} // end function
	
add_filter( 'tiny_mce_before_init', 'frontier_buttons_mce_init' ,999, 2);	



//*************************************************************************
// Enable buttons for Teeny editor
//*************************************************************************


function frontier_buttons_teeny_init( $settings, $editor_id  )
	{
	
	// get settings
	$fbut_settings	= get_option(FBUT_SETTINGS_NAME, array());
	
	
	// a cheat to display editor in frontier buttons settings
	if (strpos($editor_id, 'frontier_buttons_') !== false) 
		{
		$editor_name = substr($editor_id, 17);
		}
	else
		{
		$editor_name = FBUT_WP_TEENY_EDITOR;		
		}
	
	
	$toolbars = ( array_key_exists($editor_name, $fbut_settings) ? $fbut_settings[$editor_name] : array() );
	
	//**********************************************************************************
	// Set toolbar (Only 1 in teeny
	//**********************************************************************************
	
	$tid = "toolbar1";
	if ( array_key_exists($tid, $toolbars)  )
		{
		$settings[$tid] = implode($toolbars[$tid], ',');
		}
	
	return $settings;
	} // end function


add_filter( 'teeny_mce_before_init', 'frontier_buttons_teeny_init' ,999, 2);	




//*************************************************************************
// Enable tinyMCE editor for comments
//*************************************************************************

function frontier_buttons_comments_editor( $fields ) 
	{
	$fbut_settings	= get_option(FBUT_SETTINGS_NAME, array());
	
	if ( !fbut_bool($fbut_settings['comment_editor_enable']) )
		return $fields;
	
	$role = fbut_get_editor_role();
	
	$editor_name 		= $fbut_settings['role_editors'][$role]['cmt_editor'];		
	
	$check_editor_types	= fbut_editor_types();
	
	if ( $editor_name == FBUT_WP_STANDARD_EDITOR )
		return $fields;
	
	$tmp_args 		= array();
	$change_editor 	= false;
	
	if ( $editor_name == FBUT_WP_TEENY_EDITOR )
		{
		$tmp_args = array(
			'teeny' 		=> true,
			'textarea_rows' => intval($fbut_settings['comment_editor_lines']),
			'media_buttons' => false,
			'quicktags'		=> false,
			);
		$change_editor = true;
		}
	else
		{
		if ( array_key_exists($editor_name,$check_editor_types) )
			{
			$tmp_args = array(
				'textarea_rows' => intval($fbut_settings['comment_editor_lines']),
				'media_buttons' => false,
				'quicktags'		=> false
				);	
			$change_editor = true;
			}
		}
	
	if ( $editor_name == 'quicktags' )
		{
		$tmp_args = array(
			'textarea_rows' => intval($fbut_settings['comment_editor_lines']),
			'media_buttons' => false,
			'quicktags'		=> true
			);
		$change_editor = true;
		}
	
	
	
	if ($change_editor)
		{
		ob_start();
		wp_editor( '', 'comment', $tmp_args);
		$fields['comment_field'] = ob_get_clean();
		}
	
	/*
	error_log("******* Comment editor Fields ****");
	error_log(print_r($fields,true));
	
	error_log("******* Comment editor Args ****");
	error_log(print_r($tmp_args,true));
	*/
	
	return $fields;	
	
	} // end function		

add_filter( 'comment_form_defaults', 'frontier_buttons_comments_editor' );

//******************************************************************************
// Load tinymce plugins
//******************************************************************************

$bsettings			= get_option(FBUT_SETTINGS_NAME, array());

if ( array_key_exists('load_fbuttons_plugins', $bsettings) && fbut_bool($bsettings["load_fbuttons_plugins"]) )
	{
	add_filter('mce_external_plugins', 'frontier_buttons_mce_plugins'  );

	function frontier_buttons_mce_plugins ($plugins_array ) 
		{
		global $wp_version;
		global $tinymce_version;
	
		$folder 	= 'tinymce.'.fbut_tinymce_plugin_version();
		$plugins 	= array('table', 'searchreplace', 'preview', 'code'); 
	
		if ($tinymce_version >= "4300")
			$plugins[] 	= 'codesample'; 
	
		//Build the response - the key is the plugin name, value is the URL to the plugin JS
		foreach ($plugins as $plugin ) 
			{
			$plugins_array[ $plugin ] = FBUT_URL.'/'.$folder.'/'. $plugin . '/plugin.min.js';
			}
	
		//error_log(print_r($plugins_array,true));

		return $plugins_array;
		}
	}

//*************************************************************************
// Force default visual editor
//*************************************************************************	
function frontier_buttons_default_editor() 
	{
    if (user_can_richedit())
		return 'tinymce';
	}
add_filter( 'wp_default_editor', 'frontier_buttons_default_editor' );	


?>