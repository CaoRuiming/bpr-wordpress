<link rel="stylesheet" href="<?php echo PowerPressNetwork::powerpress_network_plugin_url(); ?>css/style.css" type="text/css"/>
<link href="<?php echo PowerPressNetwork::powerpress_network_plugin_url(). "css/blueprint.css";?>" rel="stylesheet">
<link href="<?php echo powerpress_get_root_url(). "css/subscribe-widget.css";?>" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
<?php if($props['style'] == 'older-full') {?>
    <div class="ppn-container" id="ppn-program">
        <div class="ppn-header" id="ppn-header">
            <img alt="<?php echo esc_html(($props['program_title'])) ?>" src="<?php echo esc_url(($props['artwork_url']['300'])) ?>">
            <p><?php echo esc_html(($props['program_desc'])) ?></p>
        </div>
        <br>
        <?php for ($i = 0; ($i < $props['limit'] && $i < count($props['episodes'])); $i++) {
            do_action('wp_powerpress_player_scripts');
            $player = apply_filters('powerpress_player', '', esc_url($props['episodes'][$i]['media_url']), array() );
         ?>
            <div class="entry well z-depth-1">
                <div id="ppn-episode">
                    <?php echo $player;?>
                    <div>
                        <h3><?php echo esc_html(($props['episodes'][$i]['podcast_title'])); ?></h3>
                    </div>
                    <div>
                        <p><?php echo esc_html(($props['episodes'][$i]['podcast_desc'])); ?></p>
                    </div>
                    <div>
                        <i><?php echo date('F d, Y', $props['episodes'][$i]['podcast_post_date']); ?></i>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php }elseif($props['style'] == 'artwork') { ?>
    <div class="ppn-container" id="ppn-program">
        <div class="ppn-header" id="ppn-header">
            <img alt="<?php echo esc_html((is_array($props['program_title']))) ?>" src="<?php echo esc_url(($props['artwork_url']['300'])); ?>">
        </div>
    </div>
<?php }elseif($props['style'] == 'playlist') {?>
    <div class="ppn-grid-header" bp="grid">
        <?php
        foreach ($props['episodes'] as $episode) {
            do_action('wp_powerpress_player_scripts');
            $player = apply_filters('powerpress_player', '', esc_url($episode['media_url']), array() );
            ?>
            <div class="ppn-episode-row" bp="grid 12">
                <div>
                    <h3 class="ppn-episode-title"><?php echo esc_html(($episode['podcast_title']))?></h3>
                    <p class="ppn-episode-date"><?php echo date('F d, Y', $episode['podcast_post_date']);?></p>
                </div>
                <?php echo $player;?>
                <p class="ppn-episode-description"><?php echo esc_html(($episode['podcast_desc']))?></p>
                <a class="ppn-download-link" href="<?php echo esc_url(($episode['media_url'])); ?>">
                    <div>
                        <div class="ppn-download-arrow"></div>Download
                    </div>
                </a>
            </div>
            <br>
            <?php
        }
        ?>
    </div>
<?php }elseif($props['style'] == 'description') { ?>
    <div class="ppn-container" id="ppn-program">
        <div class="ppn-header" id="ppn-header">
            <p><?php echo esc_html(($props['program_desc'])) ?></p>
        </div>
    </div>
<?php } elseif($props['style'] == 'full') {
    ?>
    <div class="ppn-grid-header" bp="grid">
        <div bp="4@lg 4@md 12@sm">
            <span class="ppn-program-artwork-cell"><img class="ppn-program-artwork" src="<?php echo esc_url(($props['artwork_url']['300']));?>"></span>
        </div>
        <div class="ppn-program-info-cell" bp="8@lg 8@md 12@sm">
            <p class="ppn-program-description"><?php echo esc_html(($props['program_desc']));?></p>
            <br />
            <b class="ppn-program-talent-name">By <?php echo esc_html(($props['talent_name'])); ?></b>
            <p class="ppn-program-url word-break"><a href="<?php echo esc_url(($props['program_url']));?>"><?php echo esc_url(($props['program_url']));?></a></p>
        </div>
        <div class="ppn-program-sub-title" bp="12">
            <h2 style="margin: 0; ">Subscribe</h2>
        </div>
        <div class="ppn-program-sub-btns" bp="12">
            <?php echo powerpress_do_subscribe_sidebar_widget(
                    [
                        'feed_url'=>esc_url($props['program_rssurl']),
                        'modern_style'=>$props['ssb-shape']=="square"?"-sq":"" ,
                        'modern_direction'=>'horizontal',
                        'itunes_url'=>esc_url($props['subscribe_itunes'] ? $props['subscribe_itunes'] : $props['program_itunesurl']),
                        'subscribe_feature_email_sidebar'=>true,
                        'subscribe_feature_android_sidebar'=>true,
                        'subscribe_feature_gp_sidebar'=>true,
                        'subscribe_feature_stitcher_sidebar'=>true,
                        'stitcher_url'=>esc_url($props['subscribe_stitcher']),
                        'subscribe_feature_tunein_sidebar'=>true,
                        'tunein_url'=>esc_url($props['subscribe_tunein']),
                        'subscribe_feature_spotify_sidebar'=>true,
                        'spotify_url'=>esc_url($props['subscribe_spotify']), //TODO make program meta have this value
                        'subscribe_feature_iheart_sidebar'=>false,
                        'iheart_url'=>esc_url($props['subscribe_iheart']), //For future use
                        'subscribe_feature_deezer_sidebar'=>false,
                        'deezer_url'=>esc_url($props['subscribe_deezer']), //For future use
                        'subscribe_feature_blubrry_sidebar'=>false,
                        'blubrry_url'=>esc_url($props['subscribe_blubrry']), //For future use
                        'subscribe_feature_podchaser_sidebar'=>false,
                        'podchaser_url'=>esc_url($props['subscribe_podchaser']), //For future use
                        'subscribe_feature_jiosaavn_sidebar'=>false,
                        'jiosaavn_url'=>esc_url($props['subscribe_jiosaavn']), //For future use
                        'subscribe_feature_gaana_sidebar'=>false,
                        'gaana_url'=>esc_url($props['subscribe_gaana']), //For future use
                        'subscribe_feature_pcindex_sidebar'=>false,
                        'pcindex_url'=>esc_url($props['subscribe_pcindex']), //For future use
                        'subscribe_feature_amazon_sidebar'=>false,
                        'amazon_url'=>esc_url($props['subscribe_amazon_music']), //For future use
                        'subscribe_feature_pandora_sidebar'=>false,
                        'pandora_url'=>esc_url($props['subscribe_pandora']), //For future use
                        'subscribe_feature_rss_sidebar'=>true,
                        'subscribe_page_url'=>esc_url($props['subscribe_html'])
                    ]) ?>
        </div>
        <?php
        foreach ($props['episodes'] as $episode) {
            do_action('wp_powerpress_player_scripts');
            $player = apply_filters('powerpress_player', '', esc_url($episode['media_url']), array() );
            ?>
            <div class="ppn-episode-row" bp="grid 12">
                <div>
                    <h3 class="ppn-episode-title word-break"><?php echo htmlspecialchars(($episode['podcast_title']))?></h3>
                    <p class="ppn-episode-date"><?php echo date('F d, Y', $episode['podcast_post_date']);?></p>
                </div>
                <?php echo $player;?>
                <p class="ppn-episode-description word-break"><?php echo htmlspecialchars(($episode['podcast_desc']))?></p>
                <a class="ppn-download-link word-break" href="<?php echo esc_url(($episode['media_url'])); ?>">
                    <div>
                        <div class="ppn-download-arrow"></div>Download
                    </div>
                </a>
            </div>
            <?php
        }
        ?>

    </div>
    <?php
}


