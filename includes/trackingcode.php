<?php

function wow_wowanalytics_should_output_trackingcode(){
 
    $options = get_option('wow_wowanalytics_options');
    $clientid_text = trim($options['clientid_text']);
    $has_clientid = !empty($clientid_text);
    
    if (!current_user_can('manage_options') && $has_clientid){
        wow_wowanalytics_output_trackingcode();
    }
    else{
        if(!current_user_can('manage_options')){
            wow_wowanalytics_output_trackingcode_noclient();
        }
        else{
            wow_wowanalytics_output_trackingcode_admin();
        }
    }
}


function wow_wowanalytics_output_trackingcode_admin(){
    $wowVersion =  constant( 'WOWANALYTICS_VERSION' );
    ?>
    <!-- WOW Async for Wordpress Tracking Code Admin User -->
    <!-- WOW Plugin Version <?php echo $wowVersion; ?> -->
<?php
}
function wow_wowanalytics_output_trackingcode_noclient(){
    $wowVersion =  constant( 'WOWANALYTICS_VERSION' );
    ?>
    <!-- WOW Async for Wordpress Tracking Code No Client Set -->
    <!-- WOW Plugin Version <?php echo $wowVersion; ?> -->
    <?php
}

function wow_wowanalytics_output_trackingcode(){
    // get the options
    $options = get_option('wow_wowanalytics_options');
    $clientid_text = trim($options['clientid_text']);
    $trackuser_bool = $options['trackuser_bool'];
	$trackdownloads_bool = $options['track_downloads_bool'];
    $wowVersion =  constant( 'WOWANALYTICS_VERSION' );
?>
    <!-- WOW Async for Wordpress Tracking Code Start -->
    <!-- WOW Plugin Version <?php echo $wowVersion; ?> -->
    <script data-cfasync='false' type='text/javascript'>
        var _wow = _wow || [];
        (function () {
            try{
                _wow.push(['setClientId', '<?php echo $clientid_text; ?>']);
                <?php
	            if(!$trackuser_bool){?>
                _wow.push(['disableUserTracking']);
                <?php
                }
                if($trackdownloads_bool){?>
                _wow.push(['enableDownloadTracking']);
                <?php } ?>
                _wow.push(['trackPageView']);
                var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                g.type = 'text/javascript'; g.defer = true; g.async = true;
                g.src = '//t.wowanalytics.co.uk/Scripts/tracker.js';
                s.parentNode.insertBefore(g, s);
            }catch(err){}})();
    </script>
    <!-- WOW Async Tracking Code End -->

<?php
}
?>