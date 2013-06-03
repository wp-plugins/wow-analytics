<?php
/*
Plugin Name: WOW Analytics Tracker
Plugin URI: http://wordpress.org/extend/plugins/wow-analytics/
Description: Inserts the WOW Analytics tracker into the footer of Wordpress pages
Version: 1.2.0
Author: WOW Analytics
Author URI: http://www.wowanalytics.co.uk
*/
/* Copyright 2012 WOW Analytics (email : support@wowanalytics.co.uk)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/
define('WOWANALYTICS_VERSION', '1.2.0');

require_once(dirname(__FILE__).'/includes/trackingcode.php');

// only include the admin functionality if the user is an admin
if ( is_admin() ){
	require_once(dirname(__FILE__).'/includes/admin.php');
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'wowanalytics_install');
//register_deactivation_hook(__FILE__, 'wowanalytics_deactivate');

// setup the options
add_action( 'plugins_loaded', 'wo_wowanalytics_plugin_setup' );


function wo_wowanalytics_plugin_setup(){
	add_action('wp_head', 'wow_wowanalytics_should_output_trackingcode');
}

function wowanalytics_deactivate(){
    delete_option('wow_wowanalytics_options');
}

function wowanalytics_install() {
    
     if ( version_compare( get_bloginfo( 'version' ), '3.0', '<' ) ) {
        deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin
        exit('This plugin requires WordPress 3.0 or greater');
    }

    $wowVersion =  constant( 'WOWANALYTICS_VERSION' );

	// get the previous version if available
    $wowOptions = get_option('wow_wowanalytics_options');
	
	// is this a clean install
	if(!$wowOptions)
	{
		// this is a clean install so we need to create the default options

        $wowOptions = array(
			'clientid_text' => '',
			'trackuser_bool' => true,
			'track_downloads_bool' => true,
			'track_download_extensions' => '',
			'version' => $wowVersion
			);
			
		add_option('wow_wowanalytics_options', $wowOptions);
	}
	else
	{
		// this is an upgrade
		if (array_key_exists('version', $wowOptions))
		{
            $prev_version = $wowOptions['version'];
            if($prev_version == null){
                $prev_version = '1.1.0';
            }
		}
		else
		{
			$prev_version = '1.0.2';
		}
		
		// this is a switch to plan for future versions
       switch($prev_version)
       {
           case '1.0.2':
               array_push($wowOptions, 'track_downloads_bool', true);
               array_push($wowOptions, 'track_download_extensions', '');
               array_push($wowOptions, 'version', $wowVersion);
               update_option( wow_wowanalytics_options, $wowOptions );
               break;
           default:
               $wowOptions['version'] = $wowVersion;
               update_option( wow_wowanalytics_options, $wowOptions ) ;
               break;
       }
	}   
    
}