<?php

/*
Used to delete options and remove capabilities when Frontier Buttons is deleted
*/

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	{
	return;
	}
	
	// Delete options
	
	
	delete_option("frontier_buttons_settings"); // pre version 2.0
	delete_option("frontier_buttons_toolbars"); // pre version 2.0
	
	delete_option("frontier-buttons-general-settings");
	
	
	
	


?>