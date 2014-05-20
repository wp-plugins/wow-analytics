<?php

function wow_wowanalytics_admin_init()
{

    add_settings_section(
        'wow_wowanalytics_main',
        'WOW Analytics Settings',
        'wow_wowanalytics_section_setup',
        'wow_wowanalytics'
    );

    add_settings_field(
        'wow_wowanalytics_clientid_text',
        'Client id',
        'wow_wowanalytics_setting_clientid',
        'wow_wowanalytics',
        'wow_wowanalytics_main'
    );

    add_settings_field(
        'wow_wowanalytics_trackuser_bool',
        'Track individual users?',
        'wow_wowanalytics_setting_trackuser',
        'wow_wowanalytics',
        'wow_wowanalytics_main'
    );

    add_settings_field(
        'wow_wowanalytics_trackdownloads_bool',
        'Track downloads?',
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
    printf('<input id="clientid_string" type="text" name="wow_wowanalytics_options[clientid_text]" size="50" value="%s" />',
    isset($clientid_string) ? esc_attr($clientid_string) : ''
    );
    ?>
    <button class="button-secondary" id="wow_clientlookup" >Lookup</button>
    <img id="wow_loading" src="<?php echo admin_url('/images/wpspin_light.gif'); ?>" class="waiting" style="display:none;" />
<?php
}

function wow_wowanalytics_setting_trackuser() {
    // get option 'text_clientid' value from the database
    $options = get_option('wow_wowanalytics_options');
    $trackuser_bool = $options['trackuser_bool'];

    printf('<input id="trackuser_bool" type="checkbox" name="wow_wowanalytics_options[trackuser_bool]" %s />',
        isset($trackuser_bool) ? checked( 1, $trackuser_bool, false ) : ''
    );
}

function wow_wowanalytics_setting_trackdownloads() {
    // get option 'text_clientid' value from the database
    $options = get_option('wow_wowanalytics_options');
    $track_downloads_bool = $options['track_downloads_bool'];

    printf('<input id="track_downloads_bool" type="checkbox" name="wow_wowanalytics_options[track_downloads_bool]" %s />',
        isset($track_downloads_bool) ? checked( 1, $track_downloads_bool, false ) : ''
    );
}

function wow_wowanalytics_validate_options($input){
    $valid = array();

    $valid['trackuser_bool'] = array_key_exists('trackuser_bool', $input);
    $valid['track_downloads_bool'] = array_key_exists('track_downloads_bool', $input);
    $valid['clientid_text'] = $input['clientid_text'];

    return $valid;
}