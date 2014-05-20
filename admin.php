<?php
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

/* Prevent direct access to the plugin */
if (!defined('ABSPATH')) {
    die("Sorry, you are not allowed to access this page directly.");
}
require_once(dirname(__FILE__) . "/includes/admin.inc.php");
require_once(dirname(__FILE__) . "/includes/ajax_functions.php");

function wow_wowanalytics_add_page()
{
    global $wow_settings;
    $wow_settings = add_options_page('WOW Analytics', 'WOW Analytics', 'manage_options', 'wow_wowanalytics', 'wow_wowanalytics_options_page');
}

// Add the admin options page to the menu
add_action('admin_menu', 'wow_wowanalytics_add_page');
// Register and define the settings
add_action('admin_init', 'wow_wowanalytics_admin_init');

// Draw the options page
function wow_wowanalytics_options_page()
{
    ?>
    <div class="wrap">

        <h2>WOW Analytics</h2>

        <form action="options.php" method="post">
            <?php
            settings_fields('wow_wowanalytics_options');
            do_settings_sections('wow_wowanalytics');
            ?>
            <?php submit_button(); ?>

        </form>
    </div>

    <div id="dialog-form" title="WOW Login Details">
        <p>Please enter your WOW login details, so that we can lookup your client id for this domain.</p>
        <form>
            <table>
                <tr>
                    <td>
                        <label for="email">Email Address:</label>
                    </td>
                    <td>
                        <input type="text" name="email" id="email" class="text ui-widget-content ui-corner-all">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password:</label>
                    </td>
                    <td>
                        <input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all">
                    </td>
                </tr>
            </table>
        </form>
    </div>
<?php
}



// Ajax code
function wow_wowanalytics_load_scripts($hook)
{
    global $wow_settings;
    if ($hook != $wow_settings)
        return;

    $scriptFile = plugins_url('/js/wow_analytics_admin.js', __FILE__);

    wp_enqueue_script('wow-admin-js', $scriptFile, array('jquery', 'jquery-ui-dialog'));
    wp_localize_script('wow-admin-js', 'wow_vars', array(
        'wow_nonce' => wp_create_nonce('wow-nonce')
    ));
    wp_enqueue_style("wp-jquery-ui-dialog");
}

add_action('admin_enqueue_scripts', 'wow_wowanalytics_load_scripts');