<?php

function wow_wowanalytics_should_output_trackingcode(){
 
    $options = get_option('wow_wowanalytics_options');
    $clientid_text = trim($options['clientid_text']);
    $has_clientid = !empty($clientid_text);
    
    if (!current_user_can('manage_options') && $has_clientid){
        wow_wowanalytics_output_trackingcode();
    }
}

function wow_wowanalytics_output_trackingcode(){
    // get the options
    $options = get_option('wow_wowanalytics_options');
    $clientid_text = trim($options['clientid_text']);
    $trackuser_bool = $options['trackuser_bool'] ? 'true' : 'false';
?>
<!-- WOW Tracking Code Start -->
<script type='text/javascript' src='//t.wowanalytics.co.uk/Scripts/tracking.js'></script>
<script type='text/javascript'>
try {
    wowTracker.ClientId = '<?php echo $clientid_text; ?>';
    wowTracker.DisableUserTracking = <?php echo $trackuser_bool; ?>;
    wowTracker.InitialiseTracker();
} catch (err) { }        
</script>
<!-- WOW Tracking Code End -->
<?php
}
?>