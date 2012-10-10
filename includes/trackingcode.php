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
    $trackuser_bool = $options['trackuser_bool'];
	$trackdownloads_bool = $options['track_downloads_bool'];
?>
<!-- WOW Tracking Code Start -->
<script type='text/javascript' src='//t.wowanalytics.co.uk/Scripts/tracker.js'></script>
<script type='text/javascript'>
try {
	// Set the tracking url
	var tracker = new wowTracking.getTracker('<?php echo $clientid_text; ?>');
	<?php
	if(!$trackuser_bool){?>
	tracker.disableUserTracking();
	<?php 
	}
	if($trackdownloads_bool){?>
	tracker.enableDownloadTracking();
	<?php }	?>
	tracker.trackPageView();
	
} catch (err) { }        
</script>
<!-- WOW Tracking Code End -->
<?php
}
?>