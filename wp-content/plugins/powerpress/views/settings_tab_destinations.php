<?php
	// settings_tab_destinations.php
	$cat_ID = '';
	if( !empty($FeedAttribs['category_id']) )
		$cat_ID = $FeedAttribs['category_id'];
	if( empty($FeedAttribs['type']) )
		$FeedAttribs['type'] = '';
	
	$feed_url = '';
	switch( $FeedAttribs['type'] )
	{
		case 'ttid': {
			$feed_url = get_term_feed_link($FeedAttribs['term_taxonomy_id'], $FeedAttribs['taxonomy_type'], 'rss2' );
		}; break;
		case 'category': {
			if( !empty($General['cat_casting_podcast_feeds']) )
				$feed_url = get_category_feed_link($cat_ID, 'podcast');
			else
				$feed_url = get_category_feed_link($cat_ID);
		}; break;
		case 'channel': {
			$feed_url = get_feed_link($FeedAttribs['feed_slug']);
		}; break;
		case 'post_type': {
			$feed_url = get_post_type_archive_feed_link($FeedAttribs['post_type'], $FeedAttribs['feed_slug']);
		}; break;
		case 'general':
		default: {
			$feed_url = get_feed_link('podcast');
		}
	}
	
	if( empty($FeedSettings['itunes_url']) )
		$FeedSettings['itunes_url'] = '';
	if( empty($FeedSettings['blubrry_url']) )
		$FeedSettings['blubrry_url'] = '';
	if( empty($FeedSettings['stitcher_url']) )
		$FeedSettings['stitcher_url'] = '';
	if( empty($FeedSettings['tunein_url']) )
		$FeedSettings['tunein_url'] = '';	
	if( empty($FeedSettings['spotify_url']) )
		$FeedSettings['spotify_url'] = '';
	if( empty($FeedSettings['google_url']) )
		$FeedSettings['google_url'] = '';
	if(empty($FeedSettings['iheart_url']) )
	    $FeedSettings['iheart_url'] = '';
	if(empty($FeedSettings['deezer_url']) )
	    $FeedSettings['deezer_url'] = '';
	if(empty($FeedSettings['pandora_url']) )
	    $FeedSettings['pandora_url'] = '';

    $Settings['subscribe_feature_rss'] = (isset($General['subscribe_feature_rss']) ? $General['subscribe_feature_rss'] : true );
    $Settings['subscribe_feature_email'] = (isset($General['subscribe_feature_email']) ? $General['subscribe_feature_email'] : false );
    $Settings['subscribe_feature_gp'] = (isset($General['subscribe_feature_gp']) ? $General['subscribe_feature_gp'] : false );
    $Settings['subscribe_feature_stitcher'] = (isset($General['subscribe_feature_stitcher']) ? $General['subscribe_feature_stitcher'] : false );
    $Settings['subscribe_feature_tunein'] = (isset($General['subscribe_feature_tunein']) ? $General['subscribe_feature_tunein'] : false );
    $Settings['subscribe_feature_spotify'] = (isset($General['subscribe_feature_spotify']) ? $General['subscribe_feature_spotify'] : false );
    $Settings['subscribe_feature_iheart'] = (isset($General['subscribe_feature_iheart']) ? $General['subscribe_feature_iheart'] : false );
    $Settings['subscribe_feature_deezer'] = (isset($General['subscribe_feature_deezer']) ? $General['subscribe_feature_deezer'] : false );
    $Settings['subscribe_feature_pandora'] = (isset($General['subscribe_feature_pandora']) ? $General['subscribe_feature_pandora'] : false );
    $Settings['subscribe_feature_android'] = (isset($General['subscribe_feature_android']) ? $General['subscribe_feature_android'] : false );
    $Settings['subscribe_feature_blubrry'] = (isset($General['subscribe_feature_blubrry']) ? $General['subscribe_feature_blubrry'] : false );
    $Settings['subscribe_feature_email_shortcode'] = (isset($General['subscribe_feature_email_shortcode']) ? $General['subscribe_feature_email_shortcode'] : true );
    $Settings['subscribe_feature_gp_shortcode'] = (isset($General['subscribe_feature_gp_shortcode']) ? $General['subscribe_feature_gp_shortcode'] : true );
    $Settings['subscribe_feature_stitcher_shortcode'] = (isset($General['subscribe_feature_stitcher_shortcode']) ? $General['subscribe_feature_stitcher_shortcode'] : true );
    $Settings['subscribe_feature_tunein_shortcode'] = (isset($General['subscribe_feature_tunein_shortcode']) ? $General['subscribe_feature_tunein_shortcode'] : true );
    $Settings['subscribe_feature_spotify_shortcode'] = (isset($General['subscribe_feature_spotify_shortcode']) ? $General['subscribe_feature_spotify_shortcode'] : true );
    $Settings['subscribe_feature_android_shortcode'] = (isset($General['subscribe_feature_android_shortcode']) ? $General['subscribe_feature_android_shortcode'] : true );
    $Settings['subscribe_feature_blubrry_shortcode'] = (isset($General['subscribe_feature_blubrry_shortcode']) ? $General['subscribe_feature_blubrry_shortcode'] : true );
    $Settings['subscribe_feature_iheart_shortcode'] = (isset($General['subscribe_feature_iheart_shortcode']) ? $General['subscribe_feature_iheart_shortcode'] : true );
    $Settings['subscribe_feature_deezer_shortcode'] = (isset($General['subscribe_feature_deezer_shortcode']) ? $General['subscribe_feature_deezer_shortcode'] : true );
    $Settings['subscribe_feature_pandora_shortcode'] = (isset($General['subscribe_feature_pandora_shortcode']) ? $General['subscribe_feature_pandora_shortcode'] : true );
    $Settings['subscribe_feature_email_sidebar'] = (isset($General['subscribe_feature_email_sidebar']) ? $General['subscribe_feature_email_sidebar'] : true );
    $Settings['subscribe_feature_gp_sidebar'] = (isset($General['subscribe_feature_gp_sidebar']) ? $General['subscribe_feature_gp_sidebar'] : true );
    $Settings['subscribe_feature_stitcher_sidebar'] = (isset($General['subscribe_feature_stitcher_sidebar']) ? $General['subscribe_feature_stitcher_sidebar'] : false );
    $Settings['subscribe_feature_tunein_sidebar'] = (isset($General['subscribe_feature_tunein_sidebar']) ? $General['subscribe_feature_tunein_sidebar'] : false );
    $Settings['subscribe_feature_spotify_sidebar'] = (isset($General['subscribe_feature_spotify_sidebar']) ? $General['subscribe_feature_spotify_sidebar'] : false );
    $Settings['subscribe_feature_iheart_sidebar'] = (isset($General['subscribe_feature_iheart_sidebar']) ? $General['subscribe_feature_iheart_sidebar'] : false );
    $Settings['subscribe_feature_deezer_sidebar'] = (isset($General['subscribe_feature_deezer_sidebar']) ? $General['subscribe_feature_deezer_sidebar'] : false );
    $Settings['subscribe_feature_pandora_sidebar'] = (isset($General['subscribe_feature_pandora_sidebar']) ? $General['subscribe_feature_pandora_sidebar'] : false );
    $Settings['subscribe_feature_android_sidebar'] = (isset($General['subscribe_feature_android_sidebar']) ? $General['subscribe_feature_android_sidebar'] : true );
    $Settings['subscribe_feature_blubrry_sidebar'] = (isset($General['subscribe_feature_blubrry_sidebar']) ? $General['subscribe_feature_blubrry_sidebar'] : false );


function subscribeSetting($directory, $feed_url, $listing_url) {
        $style = " style=\"height: 32px;\" ";
	    $link_at_top = true;
	    $id_tail = "-subsection";
	    $class = " class='pp-heading'";
	    $android_url = "";
	    $email_url = "";
        if( preg_match('/^(https?:\/\/)(.*)$/i', $feed_url, $matches ) ) {
            $android_url =  $matches[1] . 'subscribeonandroid.com/' . $matches[2];
            $email_url =  $matches[1] . 'subscribebyemail.com/' . $matches[2];
        }

	    switch ($directory) {
            case 'apple': ?>

                    <h2 class="pp-heading"><span id="apple-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Apple Podcast', 'powerpress'); ?></span></h2>
                    <?php if ($link_at_top) { ?>
                        <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/submit-podcast-to-itunes/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo __('How to submit a podcast to Apple', 'powerpress'); ?></a></b></p>
                    <?php } ?>
                    <p class="pp-settings-text"><?php echo __('Follow the steps to submit your podcast to Apple then come back here and enter the Subscription URL. Apple will email your Subscription URL to your Apple Email when your podcast is accepted into the Apple Podcasts Directory.', 'powerpress'); ?></p>
                    <?php if (!$link_at_top) { ?>
                    <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/submit-podcast-to-itunes/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo __('How to submit a podcast to Apple', 'powerpress'); ?></a></b></p>
                    <?php } ?>
                    <input class="pp-settings-text-input-less-wide" type="text" id="itunes_url<?php echo $id_tail; ?>" name="Feed[itunes_url]" placeholder="<?php echo __('Apple Subscription URL', 'powerpress'); ?>" value="<?php echo esc_attr($listing_url); ?>" maxlength="255" />
                    <label for="itunes_url" class="pp-settings-label-under"><?php echo sprintf(__('e.g. %s', 'powerpress'), 'http://itunes.apple.com/podcast/title-of-podcast/id000000000'); ?></label>

                <?php
                break;
            case 'google':
                $googleUrl =  'https://www.google.com/podcasts?feed='.powerpress_base64_encode($feed_url);?>

                    <h2 class="pp-heading"><span id="google-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Google', 'powerpress'); ?></span></h2>
                    <?php if ($link_at_top) { ?>
                    <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/submit-podcast-google-podcasts/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to Google', 'powerpress'); ?></a></b></p>
                    <?php } ?>
                    <p class="pp-settings-text"><?php echo __('Google Podcasts directory is available through Google search, Google Home smart speakers, and the new Google Podcasts app for Android. As long as your podcast website is discoverable by Google search, your podcast will be included in this directory.', 'powerpress'); ?></p>
                    <?php if (!$link_at_top) { ?>
                    <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/submit-podcast-google-podcasts/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to Google', 'powerpress'); ?></a></b></p>
                    <?php } ?>
                    <input class="pp-settings-text-input-less-wide" type="text" placeholder="<?php echo __('Google Listing URL', 'powerpress'); ?>" id="google_url_override<?php echo $id_tail; ?>" name="Feed[google_url]" value="<?php echo esc_attr($listing_url); ?>" maxlength="255"  />
                    <label for="google_url_override" class="pp-settings-label-under">e.g. <?php echo esc_attr($googleUrl); ?></label>


                <script>
                    jQuery( document ).ready(function() {
                        // Handler for .ready() called.
                        jQuery('#google_url_toggle').click( function(e) {
                            if( this.checked )  {
                                jQuery('#google_url').hide();
                                jQuery('#google_url_override').show();
                            } else {
                                if( confirm('<?php echo esc_js( __('Reset, are you sure?', 'powerpres') ); ?>') ) {
                                    jQuery('#google_url_override').val('');
                                    jQuery('#google_url_override').hide();
                                    jQuery('#google_url').show();
                                } else {
                                    e.preventDefault();
                                }
                            }
                        });
                    });
                </script>
                <?php
                break;
            case 'stitcher': ?>

                    <h2 class="pp-heading"><span id="stitcher-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Stitcher', 'powerpress'); ?></span></h2>
                    <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/publish-podcast-stitcher/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to Stitcher', 'powerpress'); ?></a></b></p>
                    <input class="pp-settings-text-input-less-wide" type="text" id="stitcher_url<?php echo $id_tail; ?>" name="Feed[stitcher_url]" placeholder="<?php echo __('Stitcher Listing URL', 'powerpress'); ?>" value="<?php echo esc_attr($listing_url); ?>" maxlength="255" />
                    <label for="stitcher_url" class="pp-settings-label-under"><?php echo sprintf(__('e.g. %s', 'powerpress'), 'http://www.stitcher.com/podcast/your/listing-url/'); ?></label>

                <?php
                break;
            case 'tunein': ?>

                    <h2 class="pp-heading"><span id="tunein-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Tunein', 'powerpress'); ?></span></h2>
                    <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/publish-podcast-tunein/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to TuneIn', 'powerpress'); ?></a></b></p>
                    <input class="pp-settings-text-input-less-wide" type="text" id="tunein_url<?php echo $id_tail; ?>" name="Feed[tunein_url]" placeholder="<?php echo __('TuneIn Listing URL', 'powerpress'); ?>" value="<?php echo esc_attr($listing_url); ?>" maxlength="255" />
                    <label for="tunein_url" class="pp-settings-label-under"><?php echo sprintf(__('e.g. %s', 'powerpress'), 'http://tunein.com/radio/your-podcast-p000000/'); ?></label>


                <?php
                break;
            case 'spotify': ?>

                    <h2 class="pp-heading"><span id="spotify-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Spotify', 'powerpress'); ?></span></h2>
                    <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/submit-podcast-to-spotify/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to Spotify', 'powerpress'); ?></a></b></p>
                    <input class="pp-settings-text-input-less-wide" type="text" id="spotify_url<?php echo $id_tail; ?>" name="Feed[spotify_url]" placeholder="<?php echo __('Spotify Listing URL', 'powerpress'); ?>" value="<?php echo esc_attr($listing_url); ?>" maxlength="255" />
                    <label for="spotify_url" class="pp-settings-label-under"><?php echo sprintf(__('e.g. %s', 'powerpress'), 'https://open.spotify.com/show/abcdefghijklmnopqrstu'); ?></label>


                <?php
                break;
            case 'blubrry': ?>

                    <h2<?php echo $class; ?>><img class="pp-directory-icon" <?php echo $style; ?>alt="" src="<?php echo powerpress_get_root_url(); ?>images/settings_nav_icons/blubrry.svg"><?php echo __('Blubrry Podcast Directory', 'powerpress'); ?></h2>
                    <?php if ($link_at_top) { ?>
                    <p class="pp-settings-text">
                        <b><a href="https://blubrry.com/addpodcast.php?feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to Blubrry Directory', 'powerpress'); ?></a></b>
                    </p>
                    <?php }?>
                    <p class="pp-settings-text">
                        <b><?php echo __('Get listed on the largest podcast directory in the world! ', 'powerpress'); ?></b><?php echo sprintf(__('Once listed, %s to expand your podcast distribution to Blubrry\'s SmartTV Apps (e.g. Roku) and apply to be on Spotify.', 'powerpress'), '<a href="https://create.blubrry.com/resources/blubrry-podcast-directory/" target="_blank">'. __('Get Featured', 'powerpress').'</a>' ); ?>
                    </p>
                    <?php if(!$link_at_top) { ?>
                    <p class="pp-settings-text">
                        <b><a href="https://blubrry.com/addpodcast.php?feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to Blubrry Directory', 'powerpress'); ?></a></b>
                    </p>
                    <?php } ?>
                    <input class="pp-settings-text-input-less-wide" type="text" id="blubrry_url<?php echo $id_tail; ?>" name="Feed[blubrry_url]" placeholder="<?php echo __('Blubrry Listing URL', 'powerpress'); ?>" value="<?php echo esc_attr($listing_url); ?>" maxlength="255" />
                    <label for="blubrry_url" class="pp-settings-label-under"><?php echo sprintf(__('e.g. %s', 'powerpress'), 'https://blubrry.com/title_of_podcast/'); ?></label>

                <?php
                break;
            case 'android': ?>
                <h2 class="pp-heading"><span id="android-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Android', 'powerpress'); ?></span></h2>
                <input class="pp-settings-text-input-less-wide" type="text" id="android_url_<?php echo $id_tail; ?>" name="null[android_url]" placeholder="<?php echo __('Subscribe by Android not available', 'powerpress'); ?>" value="<?php echo esc_attr($android_url); ?>" maxlength="255" readonly />
                <?php
                break;
            case 'email': ?>
                <h2 class="pp-heading"><span id="email-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Email', 'powerpress'); ?></span></h2>
                <input class="pp-settings-text-input-less-wide" type="text" id="email_url_<?php echo $id_tail; ?>" name="null[iheart_url]" placeholder="<?php echo __('Susbcribe on Email not available', 'powerpress'); ?>" value="<?php echo esc_attr($email_url); ?>" maxlength="255" readonly />
                <?php
                break;
            case 'iheart': ?>

                <h2 class="pp-heading"><span id="iheart-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('iHeartRadio', 'powerpress'); ?></span></h2>
                <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/submit-podcast-to-iheartradio/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to iHeartRadio', 'powerpress'); ?></a></b></p>
                <input class="pp-settings-text-input-less-wide" type="text" id="iheart_url<?php echo $id_tail; ?>" name="Feed[iheart_url]" placeholder="<?php echo __('iHeartRadio Listing URL', 'powerpress'); ?>" value="<?php echo esc_attr($listing_url); ?>" maxlength="255" />
                <label for="iheart_url" class="pp-settings-label-under"><?php echo sprintf(__('e.g. %s', 'powerpress'), 'https://www.iheart.com/podcast/abcdefghijklmopqrstu/'); ?></label>

                <?php
                break;
            case 'deezer': ?>

                <h2 class="pp-heading"><span id="deezer-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Deezer', 'powerpress'); ?></span></h2>
                <p class="pp-settings-text"><b><a href="https://blubrry.com/podcast-insider/2019/08/07/blubrry-podcasts-coming-deezer/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to Deezer', 'powerpress'); ?></a></b></p>
                <input class="pp-settings-text-input-less-wide" type="text" id="deezer_url<?php echo $id_tail; ?>" name="Feed[deezer_url]" placeholder="<?php echo __('Deezer Listing URL', 'powerpress'); ?>" value="<?php echo esc_attr($listing_url); ?>" maxlength="255" />
                <label for="deezer_url" class="pp-settings-label-under"><?php echo sprintf(__('e.g. %s', 'powerpress'), 'https://www.deezer.com/us/show/1234'); ?></label>

                <?php
                break;
            case 'pandora': ?>

                <h2 class="pp-heading"><span id="pandora-icon" class="destinations-side-icon"></span><span class="directory-summary-head"><?php echo __('Pandora', 'powerpress'); ?></span></h2>
                <p class="pp-settings-text"><b><a href="https://create.blubrry.com/manual/podcast-promotion/submit-podcast-to-pandora/?podcast-feed=<?php echo urlencode($feed_url); ?>" target="_blank"><?php echo  __('How to submit a podcast to Pandora', 'powerpress'); ?></a></b></p>
                <input class="pp-settings-text-input-less-wide" type="text" id="pandora_url<?php echo $id_tail; ?>" name="Feed[pandora_url]" placeholder="<?php echo __('Pandora Listing URL', 'powerpress'); ?>" value="<?php echo esc_attr($listing_url); ?>" maxlength="255" />
                <label for="pandora_url" class="pp-settings-label-under"><?php echo sprintf(__('e.g. %s', 'powerpress'), 'https://www.pandora.com/us/show/1234'); ?></label>

                <?php
                break;
            case 'default':
                break;
        }
    }
?>

<div class="pp-sidenav">
    <div class="pp-sidenav-extra"><p class="pp-sidenav-extra-text"><b><?php echo htmlspecialchars(__('DESTINATIONS SETTINGS', 'powerpress')); ?></b></p></div>
    <button id="destinations-default-open" class="pp-sidenav-tablinks active" onclick="sideNav(event, 'destinations-all')"><img class="pp-nav-icon" alt="" src="<?php echo powerpress_get_root_url(); ?>images/settings_nav_icons/rss-symbol.svg" style="margin-left: 7px; margin-right: 20px;width: 22px;"><?php echo htmlspecialchars(__('Basic Info', 'powerpress')); ?></button>
    <button class="pp-sidenav-tablinks" id="destinations-apple-tab" onclick="sideNav(event, 'destinations-apple')"><span id="apple-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('Apple', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-google-tab" onclick="sideNav(event, 'destinations-google')"><span id="google-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('Google', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-spotify-tab" onclick="sideNav(event, 'destinations-spotify')"><span id="spotify-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('Spotify', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-stitcher-tab" onclick="sideNav(event, 'destinations-stitcher')"><span id="stitcher-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('Stitcher', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-tunein-tab" onclick="sideNav(event, 'destinations-tunein')"><span id="tunein-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('TuneIn', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-blubrry-tab" onclick="sideNav(event, 'destinations-blubrry')"><img class="pp-nav-icon" alt="" src="<?php echo powerpress_get_root_url(); ?>images/settings_nav_icons/blubrry.svg" style="margin-left: 7px; margin-right: 20px;"><?php echo htmlspecialchars(__('Blubrry Directory', 'powerpress')); ?></button>
    <button class="pp-sidenav-tablinks" id="destinations-iheart-tab" onclick="sideNav(event, 'destinations-iheart')"><span id="iheart-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('iHeartRadio', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-deezer-tab" onclick="sideNav(event, 'destinations-deezer')"><span id="deezer-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('Deezer', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-pandora-tab" onclick="sideNav(event, 'destinations-pandora')"><span id="pandora-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('Pandora', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-android-tab" onclick="sideNav(event, 'destinations-android')"><span id="android-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('Android', 'powerpress')); ?></span></button>
    <button class="pp-sidenav-tablinks" id="destinations-email-tab" onclick="sideNav(event, 'destinations-email')"><span id="email-icon-side" class="destinations-side-icon"></span><span class="destination-side-text"><?php echo htmlspecialchars(__('Email', 'powerpress')); ?></span></button>
    <br />
    <div class="pp-sidenav-extra" style="margin-top: 200%;"><a href="https://www.blubrry.com/support/" class="pp-sidenav-extra-text"><?php echo htmlspecialchars(__('DOCUMENTATION', 'powerpress')); ?></a></div>
    <div class="pp-sidenav-extra"><a href="https://www.blubrry.com/podcast-insider/" class="pp-sidenav-extra-text"><?php echo htmlspecialchars(__('BLOG', 'powerpress')); ?></a></div>
    <br />
    <?php
    powerpressadmin_edit_blubrry_services($General);
    ?>
</div>

<div id="destinations-all" class="pp-sidenav-tab active">

    <h1 class="pp-heading"><?php echo __('Destinations', 'powerpress'); ?></h1>


    <div>
        <p style="line-height: 36px;" class="pp-settings-text"><?php echo __('Your podcast RSS feed: ', 'powerpress'); ?>
            <a href="<?php echo esc_attr($feed_url); ?>"> <?php echo esc_attr($feed_url); ?> </a>
            <br />
            <?php echo __('Use this URL to submit your podcast to various directories.', 'powerpress'); ?>
            <br />
            <?php echo __('Directory listing URLs are used by player subscribe links, subscribe sidebar widgets, and subscribe to podcast page shortcodes.', 'powerpress'); ?>
        </p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-apple" class="pp-sidenav-tab">
    <?php subscribeSetting('apple', $feed_url, $FeedSettings['itunes_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input class="pp-settings-checkbox" type="checkbox" name="NULL[subscribe_feature_itunes_sidebar]" value="1" checked disabled /> <label><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input class="pp-settings-checkbox" type="checkbox" name="NULL[subscribe_feature_itunes_shortcode]" value="1" checked disabled /> <label><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input class="pp-settings-checkbox" type="checkbox" name="NULL[subscribe_feature_itunes]" value="1" checked disabled /> <label><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-google" class="pp-sidenav-tab">
    <?php subscribeSetting('google', $feed_url, $FeedSettings['google_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_gp_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_gp_sidebar" name="General[subscribe_feature_gp_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_gp_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_gp_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_gp_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_gp_shortcode" name="General[subscribe_feature_gp_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_gp_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_gp_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input class="pp-settings-checkbox" type="checkbox" name="NULL[subscribe_feature_gp]" value="1" checked disabled/> <label for="subscribe_feature_gp_shortcode"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-stitcher" class="pp-sidenav-tab">
    <?php subscribeSetting('stitcher', $feed_url, $FeedSettings['stitcher_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_stitcher_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_stitcher_sidebar" name="General[subscribe_feature_stitcher_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_stitcher_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_stitcher_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_stitcher_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_stitcher_shortcode" name="General[subscribe_feature_stitcher_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_stitcher_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_stitcher_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_stitcher]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_stitcher" name="General[subscribe_feature_stitcher]" value="1" <?php if( !empty($Settings['subscribe_feature_stitcher']) ) echo 'checked '; ?>/> <label for="subscribe_feature_stitcher"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-tunein" class="pp-sidenav-tab">
    <?php subscribeSetting('tunein', $feed_url, $FeedSettings['tunein_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_tunein_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_tunein_sidebar" name="General[subscribe_feature_tunein_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_tunein_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_tunein_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_tunein_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_tunein_shortcode" name="General[subscribe_feature_tunein_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_tunein_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_tunein_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_tunein]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_tunein" name="General[subscribe_feature_tunein]" value="1" <?php if( !empty($Settings['subscribe_feature_tunein']) ) echo 'checked '; ?>/> <label for="subscribe_feature_tunein"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-spotify" class="pp-sidenav-tab">
    <?php subscribeSetting('spotify', $feed_url, $FeedSettings['spotify_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_spotify_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_spotify_sidebar" name="General[subscribe_feature_spotify_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_spotify_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_spotify_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_spotify_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_spotify_shortcode" name="General[subscribe_feature_spotify_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_spotify_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_spotify_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_spotify]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_spotify" name="General[subscribe_feature_spotify]" value="1" <?php if( !empty($Settings['subscribe_feature_spotify']) ) echo 'checked '; ?>/> <label for="subscribe_feature_spotify"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-blubrry" class="pp-sidenav-tab">
    <?php subscribeSetting('blubrry', $feed_url, $FeedSettings['blubrry_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_blubrry_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_blubrry_sidebar" name="General[subscribe_feature_blubrry_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_blubrry_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_blubrry_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_blubrry_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_blubrry_shortcode" name="General[subscribe_feature_blubrry_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_blubrry_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_blubrry_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_blubrry]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_blubrry" name="General[subscribe_feature_blubrry]" value="1" <?php if( !empty($Settings['subscribe_feature_blubrry']) ) echo 'checked '; ?>/> <label for="subscribe_feature_blubrry"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-iheart" class="pp-sidenav-tab">
    <?php subscribeSetting('iheart', $feed_url, $FeedSettings['iheart_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_iheart_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_iheart_sidebar" name="General[subscribe_feature_iheart_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_iheart_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_iheart_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_iheart_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_iheart_shortcode" name="General[subscribe_feature_iheart_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_iheart_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_iheart_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_iheart]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_iheart" name="General[subscribe_feature_iheart]" value="1" <?php if( !empty($Settings['subscribe_feature_iheart']) ) echo 'checked '; ?>/> <label for="subscribe_feature_iheart"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-deezer" class="pp-sidenav-tab">
    <?php subscribeSetting('deezer', $feed_url, $FeedSettings['deezer_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_deezer_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_deezer_sidebar" name="General[subscribe_feature_deezer_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_deezer_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_deezer_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_deezer_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_deezer_shortcode" name="General[subscribe_feature_deezer_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_deezer_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_deezer_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_deezer]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_deezer" name="General[subscribe_feature_deezer]" value="1" <?php if( !empty($Settings['subscribe_feature_deezer']) ) echo 'checked '; ?>/> <label for="subscribe_feature_deezer"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-pandora" class="pp-sidenav-tab">
    <?php subscribeSetting('pandora', $feed_url, $FeedSettings['pandora_url']); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_pandora_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_pandora_sidebar" name="General[subscribe_feature_pandora_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_pandora_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_pandora_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_pandora_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_pandora_shortcode" name="General[subscribe_feature_pandora_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_pandora_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_pandora_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_pandora]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_pandora" name="General[subscribe_feature_pandora]" value="1" <?php if( !empty($Settings['subscribe_feature_pandora']) ) echo 'checked '; ?>/> <label for="subscribe_feature_pandora"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>

<div id="destinations-android" class="pp-sidenav-tab">
    <?php subscribeSetting('android', $feed_url, ''); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_android_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_android_sidebar" name="General[subscribe_feature_android_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_android_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_android_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_android_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_android_shortcode" name="General[subscribe_feature_android_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_android_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_android_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_android]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_android" name="General[subscribe_feature_android]" value="1" <?php if( !empty($Settings['subscribe_feature_android']) ) echo 'checked '; ?>/> <label for="subscribe_feature_android"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>


<div id="destinations-email" class="pp-sidenav-tab">
    <?php subscribeSetting('email', $feed_url, ''); ?>
    <div class="pp-show-subscribe">
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_email_sidebar]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_email_sidebar" name="General[subscribe_feature_email_sidebar]" value="1" <?php if( !empty($Settings['subscribe_feature_email_sidebar']) ) echo 'checked '; ?>/> <label for="subscribe_feature_email_sidebar"><?php echo __('Show link in subscribe sidebar', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_email_shortcode]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_email_shortcode" name="General[subscribe_feature_email_shortcode]" value="1" <?php if( !empty($Settings['subscribe_feature_email_shortcode']) ) echo 'checked '; ?>/> <label for="subscribe_feature_email_shortcode"><?php echo __('Show link on subscribe page', 'powerpress'); ?></label></p>
        <p class="pp-settings-text-smaller-margin"><input type="hidden" name="General[subscribe_feature_email]" value="0" /><input class="pp-settings-checkbox" type="checkbox" id="subscribe_feature_email" name="General[subscribe_feature_email]" value="1" <?php if( !empty($Settings['subscribe_feature_email']) ) echo 'checked '; ?>/> <label for="subscribe_feature_email"><?php echo __('Show link under media player', 'powerpress'); ?></label></p>
    </div>
    <?php powerpress_settings_tab_footer(); ?>
</div>
<br />