<?php
/*
Plugin Name: Frontier Buttons
Plugin URI: http://wordpress.org/plugins/frontier-buttons/
Description: Full control of your WP editor toolbars. Adds Table, Search/Replace, Preview & Code sample tinymce plugins. Enable visual editor for comments.
Author: finnj
Version: 2.2.0
Author URI: http://wordpress.org/plugins/frontier-buttons/
*/


//*************************************************************************
// Constants
//*************************************************************************

// define constants
define('FRONTIER_BUTTONS_VERSION', "2.2.0"); 
define('FBUT_SETTINGS_NAME', "frontier-buttons-general-settings");
define('FBUT_EXTRA_BUTTONS_NAME', "fbut_extra_buttons_settings");

define('FBUT_TOOLBARS_NAME', "fbut_toolbars");
define('FBUT_ADD_BUTTONS_NAME', "fbut_add_buttons");
define('FBUT_PLUGIN_DIR',  dirname( __FILE__ )); //an absolute path to this directory
define('FBUT_URL', plugin_dir_url( __FILE__ )); //url path to this directory


define('FBUT_BASIC_EDITOR', 		"basic_editor");
define('FBUT_STANDARD_EDITOR', 		"standard_editor");
define('FBUT_ADVANCED_EDITOR', 		"advanced_editor");
define('FBUT_COMMENT_EDITOR', 		"comment_editor");
define('FBUT_WP_STANDARD_EDITOR',	"wp_standard");
define('FBUT_WP_TEENY_EDITOR', 		"teeny");




//*************************************************************************
// Includes
//*************************************************************************

include('include/admin-util.php');
include('include/frontier-buttons-defaults.php');
include('include/upgrade-check.php');
include('include/frontier-buttons-hooks.php');

//*************************************************************************
// Load settings menu
//*************************************************************************


include('include/settings-menu.php');
add_action('admin_menu', 'fbut_admin_menu');


//*************************************************************************
// Perform upgrade check
//*************************************************************************

frontier_buttons_upgrade_check();

//*************************************************************************
// Load scrips and CSS
//*************************************************************************

function fbut_load_prism_scripts() 
	{
    wp_enqueue_style( 'frontier-buttons-prism-css', plugins_url().'/frontier-buttons/prism/fb-prism-php.css', __FILE__, FRONTIER_BUTTONS_VERSION );
   	wp_enqueue_script('fbut_prism_script', plugins_url().'/frontier-buttons/prism/fb-prism-php.min.js', array());
    }

$bsettings	= get_option(FBUT_SETTINGS_NAME, array());	
if ( fbut_bool($bsettings['load_prism_frontend']) )
	{
	add_action( 'wp_enqueue_scripts', 'fbut_load_prism_scripts' );
	}

	

add_action( 'admin_enqueue_scripts', 'fbut_load_scripts' );
function fbut_load_scripts() 
	{
    wp_enqueue_style( 'frontier-buttons-admin-css', plugins_url().'/frontier-buttons/frontier-buttons-admin.css', __FILE__, FRONTIER_BUTTONS_VERSION );
   	wp_enqueue_script('jquery');
	}




//*************************************************************************
// Set options on activation
//*************************************************************************

function frontier_buttons_set_defaults ()
	{
	$bsettings				= get_option(FBUT_SETTINGS_NAME, array() );
			
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

	//$bsettings['fbut_last_upgrade']	= FRONTIER_BUTTONS_VERSION;

	update_option(FBUT_SETTINGS_NAME, $bsettings);
		
	}
	
register_activation_hook( __FILE__ , 'frontier_buttons_set_defaults');




//******************************************************************************
// Enable fix for reply to comments not working with teeny editor
//******************************************************************************

$bsettings	= get_option("frontier_buttons_settings", array());		

if ( array_key_exists('enable_comment_editor', $bsettings) && ($bsettings['enable_comment_editor'] == "true") && array_key_exists('comment_editor_fix', $bsettings) && ($bsettings['comment_editor_fix'] == "true") )
	{		
	//error_log("Comment fix check	: ".$bsettings['comment_editor_fix']);
	
	// wp_editor doesn't work when clicking reply. Here is the fix.
	add_action( 'wp_enqueue_scripts', '__THEME_PREFIX__scripts' );
	function __THEME_PREFIX__scripts() 
		{
		wp_enqueue_script('jquery');
		}
	
	add_filter( 'comment_reply_link', '__THEME_PREFIX__comment_reply_link' );
	function __THEME_PREFIX__comment_reply_link($link) 
		{
		return str_replace( 'onclick=', 'data-onclick=', $link );
		}
	
	add_action( 'wp_head', '__THEME_PREFIX__wp_head' );
	function __THEME_PREFIX__wp_head() 
		{
	?>
	<script type="text/javascript">
	  jQuery(function($){
		$('.comment-reply-link').click(function(e){
		  e.preventDefault();
		  var args = $(this).data('onclick');
		  args = args.replace(/.*\(|\)/gi, '').replace(/\"|\s+/g, '');
		  args = args.split(',');
		  tinymce.EditorManager.execCommand('mceRemoveEditor', true, 'comment');
		  addComment.moveForm.apply( addComment, args );
		  tinymce.EditorManager.execCommand('mceAddEditor', true, 'comment');
		});
	  });
	</script>
	<?php 
		} 
	}

//******************************************************************************
// End fix 
//******************************************************************************

//*************************************************************************
// Translation
//*************************************************************************
function frontier_buttons_translation() 
	{
	load_plugin_textdomain('frontier-buttons', false, dirname( plugin_basename( __FILE__ ) ).'/languages');
	}
add_action('plugins_loaded', 'frontier_buttons_translation');


//*************************************************************************
// End plugin
//*************************************************************************

?>