<?php
/*
Admin Utilities - Frontier  Buttons
*/

//*********************************************************************************
// Return Bool value for value
//*********************************************************************************
function fbut_bool($tmp_value)
	{
	if ( in_array($tmp_value, array('true', 'True', 'TRUE', 'yes', 'Yes', 'y', 'Y', '1','on', 'On', 'ON', true, 1), true) )
		return true;
	else
		return false;
	}

//*********************************************************************************
// comma separated list to Array
//*********************************************************************************

function fbut_list2array($tmp_list)
	{
	if (is_array($tmp_list))
		return $tmp_list;
	
	if ($tmp_list > " ")
		$tmp_array = explode(",", $tmp_list);
	else
		$tmp_array = array();
		
	return $tmp_array;
	}

//*********************************************************************************
// Remove zero from arrays
//*********************************************************************************

function fbut_array_remove_zero($tmp_array)
	{
	foreach ($tmp_array as $key => $value) 
		{
    	if (intval($value) == 0 )  
        	unset($tmp_array[$key]);
    	}
    return $tmp_array;
	}
	
//*********************************************************************************
// Remove blanks from arrays
//*********************************************************************************

function fbut_array_remove_blanks($tmp_array)
	{
	foreach ($tmp_array as $key => $value) 
		{
    	if (strlen(trim($value)) == 0 || $value == "0" )  
        	unset($tmp_array[$key]);
    	}
    return $tmp_array;
	}

//*********************************************************************************
// Return array for display in <pre> (for debug)
//*********************************************************************************

	
function fbut_print_array($tmp_array)
	{
	return "<pre>".print_r($tmp_array,true)."</pre>";
	}

//*********************************************************************************
// Get default role editor types
//*********************************************************************************

	
function fbut_get_default_role_editors($role_editors = array())
	{
	foreach (fbut_roles_caps() as $cap => $role)
		{
		foreach ( fbut_role_editor_types()  as $key => $value)
			{
			if ( !array_key_exists($cap, $role_editors) || !array_key_exists($key, $role_editors[$cap]) )
				{
				if ( in_array($cap, array('manage_options', 'edit_others_posts', 'publish_posts')) )  	
					$editor = FBUT_STANDARD_EDITOR;
				else
					$editor = FBUT_WP_TEENY_EDITOR;
				
				$role_editors[$cap][$key] = $editor;
				}
			}
		}
	return $role_editors;
	}


//*********************************************************************************
// Get editor name
//*********************************************************************************

function fbut_get_editor_role()
	{
		
	if( !is_user_logged_in() )
		return 'none';
	
	foreach (fbut_roles_caps() as $cap => $role)
		{
		if ( current_user_can($cap) )
			return $cap;
		}

	// just to be sure, return none if none of the above returned	
	return 'none';
	}


//*********************************************************************************
// Get tinymce version
//*********************************************************************************

//Wordpress version	WP tinymce version
// 3.9.11	4021-20150505
// 4.0.10	4104-20150505
// 4.1.10	4107-20150505
// 4.2.7	4109-20150505
// 4.3.3	4205-20150910
// 4.4.2	4208-20151113
// 4.5-beta	4304-20160219




function fbut_tinymce_plugin_version()
	{
	global $wp_version;
	global $tinymce_version;
	
	$tmp_tinymce_version = intval(substr( ((isset($tinymce_version) && strlen($tinymce_version)>0) ? $tinymce_version : "0000"),0,4));
	
	//error_log("tinymce_version: ".$tinymce_version."  tmp--> ".$tmp_tinymce_version);
	//echo "<pre>tinymce_version: ".$tinymce_version."  tmp--> ".$tmp_tinymce_version."</pre>";
	
		
	if ($tmp_tinymce_version <= 4109)
		return "4.1.9";
		
	if ($tmp_tinymce_version <= 4205)
		return "4.2.5";
	
	if ($tmp_tinymce_version <= 4208)
		return "4.2.8";
	
	if ($tmp_tinymce_version >= 4303)
		return "4.3.12";
	
	
	// last
	if ($tmp_tinymce_version >= 4400)
		return "4.4.0";
	
	
	return "4.4.0";
	
	
	}
	

?>