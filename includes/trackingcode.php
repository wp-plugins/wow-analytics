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
    $track_download_extensions_text = $options['track_download_extensions'];
?>
    <!-- WOW Async Tracking Code Start -->
    <script type='text/javascript'>
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
                <?php }	?>
                <?php
                if($track_download_extensions_text != ''){?>
                _wow.push(['setDownloadExtensions', '<?php echo $track_download_extensions_text?>'])
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