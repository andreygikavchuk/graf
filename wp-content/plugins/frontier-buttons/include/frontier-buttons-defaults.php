<?php
//*******************************************************************************************************
//Default values for Frontier Buttons plugin
//*******************************************************************************************************

//*******************************************************************************************************
// ALL Standard wordpress buttons in tinyMCE editor
//*******************************************************************************************************

function fbut_all_wp_std_buttons()
	{
	return  array( 	'bold', 
					'italic', 
					'strikethrough', 
					'bullist', 
					'numlist', 
					'blockquote', 
					'hr', 
					'alignleft', 
					'aligncenter', 
					'alignright', 
					'link', 
					'unlink', 
					'wp_more', 
					'dfw', 
					'wp_adv', 
					'formatselect', 
					'underline', 
					'alignjustify', 
					'forecolor', 
					'pastetext', 
					'removeformat', 
					'charmap', 
					'outdent', 
					'indent', 
					'undo', 
					'redo', 
					'wp_help',
					'fontselect', 
					'fontsizeselect', 
					'styleselect', 
					'media', 
					'image', 
					'backcolor', 
					'subscript', 
					'superscript'	
					);
	
	}

//*******************************************************************************************************
// ALL Standard buttons including Frontier Buttons
//*******************************************************************************************************


function fbut_all_std_buttons()
	{
	return array_merge_recursive(fbut_all_wp_std_buttons(), array_keys(fbut_included_buttons()) );
	}

//*******************************************************************************************************
// ALL Standard buttons including Frontier Buttons
//*******************************************************************************************************


function fbut_no_icon_buttons()
	{
	return array('fontselect', 'fontsizeselect', 'styleselect', 'formatselect');
	}






//*******************************************************************************************************
// Default buttons
//*******************************************************************************************************


function fbut_default_toolbars()
	{
	$basic_editor 				= array();
	$basic_editor["toolbar1"] 	= array( 'bold', 'italic', 'underline', 'strikethrough', 'bullist', 'numlist',  'alignleft', 'aligncenter', 'alignright', 'alignjustify', 'link', 'unlink' );
	$basic_editor["toolbar2"] 	= array();
	$basic_editor["toolbar3"] 	= array();
	$basic_editor["toolbar4"] 	= array();
	
	$standard_editor 				= array();
	$standard_editor["toolbar1"] 	= array( 'bold', 'italic', 'underline', 'strikethrough', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'alignjustify', 'removeformat', 'link', 'unlink', 'wp_adv' );
	$standard_editor["toolbar2"] 	= array( 'fontselect' , 'fontsizeselect', 'forecolor', 'backcolor', 'pastetext', 'outdent', 'indent', 'wp_help');
	$standard_editor["toolbar3"] 	= array();
	$standard_editor["toolbar4"] 	= array();
	
	$advanced_editor 				= array();
	$advanced_editor["toolbar1"] 	= array( 'bold', 'italic', 'underline', 'strikethrough', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'alignjustify', 'removeformat', 'link', 'unlink', 'wp_adv' );
	$advanced_editor["toolbar2"] 	= array( 'fontselect' , 'fontsizeselect', 'forecolor', 'backcolor', 'pastetext', 'outdent', 'indent');
	$advanced_editor["toolbar3"] 	= array( 'media', 'image', 'searchreplace', 'table', 'preview', 'codesample', 'code' );
	$advanced_editor["toolbar4"] 	= array();

	$comment_editor 				= array();
	$comment_editor["toolbar1"] 	= array( 'bold', 'italic', 'underline', 'strikethrough', 'bullist', 'numlist', 'link', 'unlink', 'alignleft', 'aligncenter', 'alignright', 'wp_adv' );
	$comment_editor["toolbar2"] 	= array('forecolor','image', 'preview', 'codesample', 'charmap', 'pastetext', 'removeformat' );
	$comment_editor["toolbar3"] 	= array();
	$comment_editor["toolbar4"] 	= array();
	
	$teeny_editor 				= array();
	$teeny_editor ["toolbar1"] 	= array( 'bold', 'italic', 'underline', 'strikethrough', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'alignjustify', 'link', 'unlink', 'wp_more' );
	$teeny_editor ["toolbar2"] 	= array();
	$teeny_editor ["toolbar3"] 	= array();
	$teeny_editor ["toolbar4"] 	= array();
	
	
	$fbut_default_buttons = array(
		FBUT_STANDARD_EDITOR	=> $standard_editor,
		FBUT_ADVANCED_EDITOR	=> $advanced_editor,
		FBUT_BASIC_EDITOR		=> $basic_editor,
		FBUT_COMMENT_EDITOR		=> $comment_editor,
		FBUT_WP_TEENY_EDITOR	=> $teeny_editor,
		);
	
	
	return $fbut_default_buttons;
	}


//*******************************************************************************************************
// tinyMCE modules loaded with Wordpress
//*******************************************************************************************************
function fbut_editor_types()
	{
	return array(
		FBUT_STANDARD_EDITOR	=> __("Standard Editor", "frontier-buttons"),
		FBUT_ADVANCED_EDITOR	=> __("Advanced Editor", "frontier-buttons"),
		FBUT_BASIC_EDITOR		=> __("Basic Editor", "frontier-buttons"),
		FBUT_COMMENT_EDITOR		=> __("Comment Editor", "frontier-buttons"),
		FBUT_WP_TEENY_EDITOR	=> __("Teeny Editor", "frontier-buttons"),
		);
	}

//*******************************************************************************************************
// Buttons with no corresponding icon, as they are dropdowns instead
//*******************************************************************************************************

/*
function fbut_noicon_buttons()
	{
	return array('fontselect', 'fontsizeselect', 'styleselect', 'formatselect');	
	}
*/

//*******************************************************************************************************
// tinyMCE modules loaded with Wordpress
//*******************************************************************************************************


function fbut_wp_tinymce_plugins()
	{
	return array('charmap', 'colorpicker', 'hr', 'lists', 'image', 'media', 'paste', 'tabfocus', 'textcolor', 'fullscreen');
	}


//*******************************************************************************************************
// tinyMCE plugins loaded with FRONTIER BUTTONS
//*******************************************************************************************************

function fbut_included_tinymce_plugins()
	{
	global $tinymce_version;
	
	$plugins = array(
		'searchreplace'	=> __('Search Replace', 'frontier-buttons'),
		'table' 		=> __('Table', 'frontier-buttons'),
		'preview'		=> __('Preview', 'frontier-buttons'),
		'code'			=> __('Code', 'frontier-buttons'),
		);
	
	// codesample plugin requires yinyMCE version 4.3 or above
	if (intval(substr( ((isset($tinymce_version) && strlen($tinymce_version)>0) ? $tinymce_version : "0000"),0,4)) >= "4300")
		$plugins['codesample']	= __('Code Sample', 'frontier-buttons');
	
	return $plugins;
	}
	
//*******************************************************************************************************
// tinyMCE buttons loaded with FRONTIER BUTTONS
//*******************************************************************************************************

function fbut_included_buttons()
	{
	global $tinymce_version;
	// load settings
	$bsettings			= get_option(FBUT_SETTINGS_NAME, array());
	
	if ( array_key_exists('load_fbuttons_plugins', $bsettings) && fbut_bool($bsettings["load_fbuttons_plugins"]) )
		{
		// Simple (at the moment, only one button per plugin with same button name as plugin
		$buttons = array(
			'searchreplace'	=> __('Search Replace', 'frontier-buttons'),
			'table' 		=> __('Table', 'frontier-buttons'),
			'preview'		=> __('Preview', 'frontier-buttons'),
			'code'			=> __('Code', 'frontier-buttons'),
		);
	
		// codesample plugin requires yinyMCE version 4.3 or above
		if (intval(substr( ((isset($tinymce_version) && strlen($tinymce_version)>0) ? $tinymce_version : "0000"),0,4)) >= "4300")
			$buttons['codesample']	= __('Code Sample', 'frontier-buttons');
		}
	else
		{
		$buttons = array();
		}

	return $buttons;
	}
	
//*******************************************************************************************************
// Settings default values
//*******************************************************************************************************

function fbut_default_settings()
	{
	return array(
		//'visual_editor_enable'	=> true,
		//'editor_lines'			=> 10,
		'comment_editor_enable'	=> false,
		//'comment_editor_type'	=> 'teeny',
		//'comment_editor_login'	=> true,
		'comment_editor_fix'	=> true,
		'comment_editor_lines'	=> 10,
		'add_text_to_buttons'	=> true,
		'extra_buttons'			=> array(),
		'detected_buttons'		=> array(),
		'force_frontend_check'	=> true,
		'force_backend_check'	=> true,
		'load_prism_frontend'	=> false,
		//'cap_editor_list'		=> fbut_default_editor_list(),		
		//'cap_cmt_editor_list'	=> fbut_default_cmt_editor_list(),
		'last_backend_detect'	=> 0,
		'last_frontend_detect'	=> 0,
		'load_fbuttons_plugins'	=> true,
		'std_editor'			=> FBUT_STANDARD_EDITOR,
		'std_cmt_editor'		=> FBUT_COMMENT_EDITOR,
		'use_role_editors'		=> true,
		
		);
	}

//*******************************************************************************************************
// Settings bool values (for check for false, as field will be non existing in $_POST
//*******************************************************************************************************


function fbut_bool_settings()
	{
	return array(
		'visual_editor_enable',
		'comment_editor_enable',
		'comment_editor_login',
		'comment_editor_fix',
		'add_text_to_buttons',
		'force_frontend_check',
		'force_backend_check',
		'load_prism_frontend',
		'load_fbuttons_plugins',
		'use_role_editors',
		);
	}

//*******************************************************************************************************
// Choise for extra buttons
//*******************************************************************************************************


function fbut_extra_button_choice()
	{
	return array(
		'new'		=> __("New", "frontier-buttons"),
		'add'		=> __("Add", "frontier-buttons"),
		'ignore'	=> __("Ignore", "frontier-buttons"),
		'delete'	=> __("Delete", "frontier-buttons"),
		
		);
	}
	
//*******************************************************************************************************
// Role / Caps
//*******************************************************************************************************
	

function fbut_roles_caps()
	{
	return array(
		'manage_options' 	=> __("Administrators", "frontier-buttons"),
		'edit_others_posts' => __("Editors", "frontier-buttons"),
		'publish_posts' 	=> __("Authors", "frontier-buttons"),
		'edit_posts' 		=> __("Contributors", "frontier-buttons"),
		'read' 				=> __("Subscribers", "frontier-buttons"),
		'none' 				=> __("Guests", "frontier-buttons"),
		);
	
	}




//*******************************************************************************************************
// Editor List tinyMCE
//*******************************************************************************************************
	
function fbut_editor_list()
	{
	return fbut_editor_types()+array( 
							FBUT_WP_STANDARD_EDITOR	=> __("Wordpress standard", "frontier-buttons") 
							);
	
	}

//*******************************************************************************************************
// Editor List Comments
//*******************************************************************************************************
	
function fbut_cmt_editor_list()
	{
	//return fbut_editor_list()+array('quicktags'	=> __("Quicktags", "frontier-buttons") );
	return fbut_editor_list();
	}

	
//*******************************************************************************************************
// Default editor
//*******************************************************************************************************
	
function fbut_default_editor_list()
	{
	return array(
		'manage_options' 	=> FBUT_ADVANCED_EDITOR,
		'edit_others_posts' => FBUT_STANDARD_EDITOR,
		'publish_posts' 	=> FBUT_STANDARD_EDITOR,
		'edit_posts' 		=> FBUT_STANDARD_EDITOR,
		'read' 				=> FBUT_BASIC_EDITOR,
		'none' 				=> 'teeny',
		);
	
	}
	
//*******************************************************************************************************
// Default COMMENT editor
//*******************************************************************************************************
	
function fbut_default_cmt_editor_list()
	{
	return array(
		'manage_options' 	=> FBUT_ADVANCED_EDITOR,
		'edit_others_posts' => FBUT_STANDARD_EDITOR,
		'publish_posts' 	=> FBUT_COMMENT_EDITOR,
		'edit_posts' 		=> FBUT_COMMENT_EDITOR,
		'read' 				=> FBUT_COMMENT_EDITOR,
		'none' 				=> FBUT_COMMENT_EDITOR,
		);
	
	}

//*******************************************************************************************************
// Default COMMENT editor
//*******************************************************************************************************
	
function fbut_role_editor_types()
	{
	return array(	'default_editor' 	=> __("Editor", "frontier-buttons"), 
					'cmt_editor' 		=> __("Comments editor", "frontier-buttons"),
					);
	}

//*******************************************************************************************************
// Detection interval for check of new buttons
//*******************************************************************************************************
	
function fbut_detect_interval()
	{
	return 60*60; // 1 hour
	}
?>