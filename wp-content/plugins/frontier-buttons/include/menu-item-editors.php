<?php
/*
Editors settings - Frontier  Buttons
*/

function fbut_button_html($identifier)
		{
		return '<fieldset class="f-b-button" role="presentation" type="button" id="'.$identifier.'" draggable="true" ondragstart="drag(event)"><i class="mce-ico mce-i-'.$identifier.' f-b-button-icon"></i>&nbsp;'.$identifier.'</fieldset>';		
		}
	

function fbut_menu_editor($fbut_module)
	{
	
		
	
	//global $wp_version, $tinymce_version;
	
	//$fbut_editor_types 			= array('full' => __('Full Editor', 'frontier-buttons'), 'teeny' => __('Visual simple', 'frontier-buttons'), 'quicktags' => __('Quicktags', 'frontier-buttons'));

	
	// load settings
	$bsettings			= get_option(FBUT_SETTINGS_NAME, array());
	
	
	//*************************************************************************
	// jquery & js scripts
	//*************************************************************************
	
	?>
	<script type="text/javascript">  
	jQuery(document).ready(function($) 
		{
        // add add your function in the format $()

    	$('#frontier_buttons_settings').on('submit', function() 
    		{
			var ordered_list1 = [];
			$("#toolbar_dropzone_1 fieldset").each(function() 
				{
				ordered_list1.push($(this).attr('id'));
				}
			);
			$("#toolbar1").val(JSON.stringify(ordered_list1));
			
			
			var ordered_list2 = [];
			$("#toolbar_dropzone_2 fieldset").each(function() 
				{
				ordered_list2.push($(this).attr('id'));
				}
			);
			$("#toolbar2").val(JSON.stringify(ordered_list2));	
			
			
			var ordered_list3 = [];
			$("#toolbar_dropzone_3 fieldset").each(function() 
				{
				ordered_list3.push($(this).attr('id'));
				}
			);
			$("#toolbar3").val(JSON.stringify(ordered_list3));	
			
			
			var ordered_list4 = [];
			$("#toolbar_dropzone_4 fieldset").each(function() 
				{
				ordered_list4.push($(this).attr('id'));
				}
			);
			$("#toolbar4").val(JSON.stringify(ordered_list4));	
			
			
			}
			
		);
		}
	);
	</script>	
	<script>
		function allowDrop(ev) 
			{
			ev.preventDefault();
			}

		function drag(ev) 
			{
			ev.dataTransfer.setData("text", ev.target.id);
			}

		function drop(ev) 
			{
			ev.preventDefault();
			var data = ev.dataTransfer.getData("text");
			ev.target.appendChild(document.getElementById(data));
   
			}
    </script>
	
	<?php
	
	//*************************************************************************
	// setup toolbars
	//*************************************************************************
	
	//$std_buttons 			= fbut_wp_std_buttons();	
	$default_toolbars		= fbut_default_toolbars();
	//$included_plugins		= fbut_included_plugins();
	$all_std_buttons		= fbut_all_std_buttons();
	
	$extra_buttons			= $bsettings['extra_buttons'];
	
	$add_text_to_buttons 	= fbut_bool($bsettings['add_text_to_buttons']);
	
	
	//$flist = $fbut_buttons["button_list"]; 
	
	//echo "std Buttons: "."<pre>".print_r($std_buttons, true)."</pre><br>";
	//echo "Default Toolbars: "."<pre>".print_r($default_toolbars, true)."</pre><br>";
	
	$all_buttons	= array_merge_recursive($all_std_buttons, $extra_buttons);
	$source 		= $all_buttons;
	$no_icon		= array_merge_recursive(fbut_no_icon_buttons(), $extra_buttons);
	
	$toolbars = (array_key_exists($fbut_module, $bsettings) ? $bsettings[$fbut_module] : $default_toolbars[$fbut_module] );
	
	
	// Remove buttons assigned buttons from source.
	for ($i = 1; $i <= 4; $i++) 
		{
		if (!array_key_exists("toolbar".$i, $toolbars) || !is_array($toolbars["toolbar".$i]) )
			$toolbars["toolbar".$i] = array();
		else
			$source = array_diff($source, $toolbars["toolbar".$i]);
	
		// Remove undefined buttons
		$toolbars["toolbar".$i] = array_intersect($toolbars["toolbar".$i], $all_buttons);
		} 
	
	
	//*************************************************************************
	// Display form
	//*************************************************************************
			
	
	echo '<form name="frontier_buttons_settings" id="frontier_buttons_settings" method="post" action="">';
	echo '<input type="hidden" name="menu_item" value="'.$fbut_module.'"></input>';
	
	echo PHP_EOL;
	for ($i = 1; $i <= 4; $i++) 
		{
		echo '<input id="toolbar'.$i.'" type="hidden" name="toolbar'.$i.'">'.PHP_EOL;
		}
	
	
	// display available buttons 
	echo '<fieldset id="fsource" class="f-b-source-buttons" ondrop="drop(event)" ondragover="allowDrop(event)"><legend>Source</legend>';
	foreach ($source as $key => $value)
		{
		if ( in_array($value, $no_icon) || $add_text_to_buttons)
			echo '<fieldset class="f-b-button" role="presentation" type="button" id="'.$value.'" draggable="true" ondragstart="drag(event)"><i class="mce-ico mce-i-'.$value.' f-b-button-icon"></i>&nbsp;'.$value.'</fieldset>';
		else
			echo '<fieldset class="f-b-button" role="presentation" type="button" id="'.$value.'" draggable="true" ondragstart="drag(event)"><i class="mce-ico mce-i-'.$value.' f-b-button-icon"></i></fieldset>';
		
		}
	echo '</fieldset>';

	// display toolbars
	for ($i = 1; $i <= 4; $i++) 
		{
		echo '<fieldset id="toolbar_dropzone_'.$i.'" name="toolbar_dropzone_'.$i.'" class="f-b-toolbar" ondrop="drop(event)" ondragover="allowDrop(event)"><legend>Toolbar '.$i.'</legend>'.PHP_EOL;
		// Display buttons
		$tmp_toolbar = $toolbars["toolbar".$i];
		foreach ($tmp_toolbar as $key => $value)
			{
			if ( in_array($value, $no_icon)  || $add_text_to_buttons )
				echo '<fieldset class="f-b-button" role="presentation" type="button" id="'.$value.'" draggable="true" ondragstart="drag(event)"><i class="mce-ico mce-i-'.$value.' f-b-button-icon"></i>&nbsp;'.$value.'</fieldset>';
			else
				echo '<fieldset class="f-b-button" role="presentation" type="button" id="'.$value.'" draggable="true" ondragstart="drag(event)"><i class="mce-ico mce-i-'.$value.' f-b-button-icon"></i></fieldset>';
		
			//echo fbut_button_html($value);
			} // buttons
		echo '</fieldset>';
		} // toolbars
	
	if (wp_is_mobile())
		$info_class = "frontier-buttons-warning";
	else
		$info_class = "frontier-buttons-info";
	
	echo '<div class="frontier-buttons-info-block">';
		echo '<div class="'.$info_class.'">* '.__("Drag & Drop of buttons does not work with mobile devices, you need a computer/laptop", "frontier-buttons").'</div><br>';
	echo '</div><br>';
	echo '<button class="button frontier-buttons-submit" type="submit" name="frontier-buttons-submit" id="frontier-buttons-submit" value="'.$fbut_module.'">'.__("Save", "frontier-buttons").'</button>';	
	echo '<button class="button frontier-buttons-reset" type="submit" name="frontier-buttons-reset" id="frontier-buttons-reset" value="'.$fbut_module.'">'.__("Reset toolbar to default", "frontier-buttons").'</button>';	
	
	echo '<br>';
	
	echo '</form>';
	} //function fbut_main_settings
			
	
	
	?>