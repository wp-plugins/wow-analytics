<?php
/**
 * Created by PhpStorm.
 * User: kenlea
 * Date: 19/05/2014
 * Time: 10:41
 */
/* Prevent direct access to the plugin */
if (!defined('ABSPATH')) {
    die("Sorry, you are not allowed to access this page directly.");
}

require_once(dirname(__FILE__) . "/restclient.php");
/* create the ajax functions */

function wow_wowanalytics_client_list()
{

    if (!isset($_POST['wow_nonce']) || !wp_verify_nonce($_POST['wow_nonce'], 'wow-nonce'))
        die('Permission check failed');

    $subject = get_template_directory_uri();
    if (preg_match('/\b(?P<protocol>https?|ftp):\/\/(?P<domain>[-A-Z0-9.]+)(?P<file>\/[-A-Z0-9+&@#\/%=~_|!:,.;]*)?(?P<parameters>\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i', $subject, $regs)) {
        $wpDomain = $regs['domain'];
    } else {
        $wpDomain = "";
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // check the client
    $api = new RestClient(array(
        "base_url" => "https://api.app.wowanalytics.co.uk",
        //'format' => "json",,
        "user_agent" => "wow-analytics-wordpress-plugin/2.0",
        "headers" => array(
            "_username" => $email,
            "_password" => $password,
            "_api-version", "1"),
    ));

    $result = $api->get("clients/");

    $result_json = array('client' => NULL, 'error' => NULL);

    if ($result->info->http_code == 200 && isset($wpDomain)) {
        $wowClients = $result->decode_response();
        //echo count($wowClients);
        foreach ($wowClients as $client) {
            foreach ($client->domains as $domain) {
                if(str_ends_with($domain, $wpDomain)){
                    $result_json['client'] = $client->id;
                    break;
                }
            }
            if(isset($result_json['client'])){
                break;
            }
        }
        if(!isset($result_json['client'])){
            $result_json['error'] = "Unable to find client for this domain.";
        }
    }
    else{
        $result_json['error'] = "Unable to connect to WOW, please check login details";
    }
    // headers for not caching the results
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

    // headers to tell that result is JSON
    header('Content-type: application/json');

    // send the result now
    echo json_encode($result_json);

    exit();
}

function str_ends_with($haystack, $needle)
{
    return strpos($haystack, $needle) + strlen($needle) ===
    strlen($haystack);
}

/* Setup the ajax calls */
add_action("wp_ajax_wow_client_list", "wow_wowanalytics_client_list");