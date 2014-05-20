<?php 
// If uninstall is not calledfrom WordPress exit
if(!defined('WP_UNINSTALL_PLUGIN'))
	exit();
	
// Delete option from options table
delete_option('wow_wowanalytics_options');
