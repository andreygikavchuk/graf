<?php
/*
Main menu - Frontier  Buttons
*/


function fbut_menu_extra_buttons($fbut_module)
	{
	
	
	// load settings
	$bsettings				= get_option(FBUT_SETTINGS_NAME, array());
	$detected_buttons 		= $bsettings['detected_buttons'];
	$extra_button_choice	= fbut_extra_button_choice();
	
	echo '<form name="frontier_buttons_settings" method="post" action="">';
	echo '<input type="hidden" name="menu_item" value="'.$fbut_module.'"></input>';
	
	//echo "** TEST **";
	
	echo '<table class="fbut-extra-buttons">';
	echo '<tr>';
		echo '<th class="frontier-buttons-table-heading">'.__("Button id", "frontier-buttons").'</th>';
		echo '<th class="frontier-buttons-table-heading">'.__("Status", "frontier-buttons").'</th>';
		echo '<th class="frontier-buttons-table-heading">'.__("Detected Frontend", "frontier-buttons").'</th>';
		echo '<th class="frontier-buttons-table-heading">'.__("Detected Backend", "frontier-buttons").'</th>';
	echo '</tr>';
	foreach ($detected_buttons as $key => $value)
		{
		echo '<tr>';
		//echo '<td class="fbut-extra-buttons">'.$key.'</td>';
		//echo '<td class="fbut-extra-buttons"><i class="mce-ico mce-i-'.$key.' f-b-button-icon"></i><'.$key.'/td>';
		echo '<td class="fbut-extra-buttons"><i class="mce-ico mce-i-'.$key.'"></i>  '.$key.'</td>';
		echo '<td class="fbut-extra-buttons"><select name="extra_button_status_'.$key.'" >';
		foreach($extra_button_choice as $id => $desc) :    
			echo '<option value="'.$id.'" ';
			if ( $id == (array_key_exists('status',$value) ? $value["status"] : "new") )
				echo 'selected="selected"';
			echo '>'.$desc.'</option>';
		endforeach;
		echo '</select></td>';
	
		echo '<td class="fbut-extra-buttons">'.(array_key_exists('frontend_discovered',$value) ? $value['frontend_discovered'] : " ").'</td>';
		echo '<td class="fbut-extra-buttons">'.(array_key_exists('backend_discovered',$value) ? $value['backend_discovered'] : " ").'</td>';
		echo '</tr>';
		}
	
	
	
	
	
	
	echo '</table>';
	echo '<br>';
	echo '<button class="button frontier-buttons-submit" type="submit" name="frontier-buttons-submit" id="frontier-buttons-submit" value="'.$fbut_module.'">Save</button>';	
	echo '<br>';
	
	echo '</form>';
	} //function fbut_main_settings
			

	
	?>