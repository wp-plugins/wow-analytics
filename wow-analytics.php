<?php
/*
Plugin Name: WOW Analytics Tracker
Plugin URI: http://wordpress.org/extend/plugins/wow-analytics/
Description: Inserts the WOW Analytics tracker into the footer of Wordpress pages
Version: 2.0.1
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
define('WOWANALYTICS_VERSION', '2.0');

require_once(dirname(__FILE__).'/includes/trackingcode.php');
require_once(dirname(__FILE__).'/install.php');

// only include the admin functionality if the user is an admin
if ( is_admin() ){
	require_once(dirname(__FILE__).'/admin.php');
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
