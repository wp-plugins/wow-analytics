<?php

// Add the admin options page
add_action('admin_menu', 'wow_wowanalytics_add_page');

function wow_wowanalytics_add_page() {
    add_options_page( 'WOW Analytics', 'WOW Analytics', 'manage_options', 'wow_wowanalytics', 'wow_wowanalytics_options_page' );
}

// Draw the options page
function wow_wowanalytics_options_page() {
?>
<div class="wrap" >
<?php screen_icon(); ?>
<h2>WOW Analytics</h2>
<form action="options.php" method="post" >
 <?php
 settings_fields('wow_wowanalytics_options');
 do_settings_sections('wow_wowanalytics');
 ?>
    <input name="submit" type="submit" value="Save Changes" />
</form >
</div>
<?php
}

// Register and define the settings
add_action('admin_init', 'wow_wowanalytics_admin_init');

function wow_wowanalytics_admin_init(){
      
    add_settings_section(
        'wow_wowanalytics_main',
        'WOW Analytics Settings',
        'wow_wowanalytics_section_setup',
        'wow_wowanalytics'
        );
        
    add_settings_field(
        'wow_wowanalytics_clientid_text',
        'Please enter your client id',
        'wow_wowanalytics_setting_clientid',
        'wow_wowanalytics',
        'wow_wowanalytics_main'
        );
        
    add_settings_field(
        'wow_wowanalytics_trackuser_bool',
        'Do you want to track individual users',
        'wow_wowanalytics_setting_trackuser',
        'wow_wowanalytics',
        'wow_wowanalytics_main'
        );
    
	add_settings_field(
        'wow_wowanalytics_trackdownloads_bool',
        'Do you want to track downloads',
        'wow_wowanalytics_setting_trackdownloads',
        'wow_wowanalytics',
        'wow_wowanalytics_main'
        );
		
    register_setting(
        'wow_wowanalytics_options',
        'wow_wowanalytics_options',
        'wow_wowanalytics_validate_options'
    );
}

// Explinations about this section
function wow_wowanalytics_section_setup() {
    echo '<p>Please enter your settings below.</p>';
}

// Display and fill the form field
function wow_wowanalytics_setting_clientid() {
    // get option 'text_clientid' value from the database
    $options = get_option('wow_wowanalytics_options');
    $clientid_string = $options['clientid_text'];
    // echo the field
    echo "<input id='clientid_string' name='wow_wowanalytics_options[clientid_text]' size='50' type='text' value='{$clientid_string}' />";
}

function wow_wowanalytics_setting_trackuser() {
    // get option 'text_clientid' value from the database
    $options = get_option('wow_wowanalytics_options');
    $trackuser_bool = $options['trackuser_bool'];
    // echo the field
    echo '<input id="trackuser_bool" name="wow_wowanalytics_options[trackuser_bool]" type="checkbox" ' . checked( 1, $trackuser_bool, false ) . '" />';
}

function wow_wowanalytics_setting_trackdownloads() {
    // get option 'text_clientid' value from the database
    $options = get_option('wow_wowanalytics_options');
    $track_downloads_bool = $options['track_downloads_bool'];
    // echo the field
    echo '<input id="track_downloads_bool" name="wow_wowanalytics_options[track_downloads_bool]" type="checkbox" ' . checked( 1, $track_downloads_bool, false ) . '" />';
}

function wow_wowanalytics_validate_options($input){
    $valid = array();
    
    $valid['trackuser_bool'] = array_key_exists('trackuser_bool', $input);
    $valid['track_downloads_bool'] = array_key_exists('track_downloads_bool', $input);
    $valid['clientid_text'] = $input['clientid_text'];
    
    return $valid;
}

?>