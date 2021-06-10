<?php
class PowerPressStatsWidget
{
    var $content = array();
    function __construct() {
        $this->powerpress_get_stats_data();
    }
    
    /**
     * Prints Blubrry Stats Widget to the WordPress dashboard, first making an API call to refresh the stats if necessary
     */
    function powerpress_get_stats_data()
    {
        $Settings = get_option('powerpress_general');
        $creds = get_option('powerpress_creds');
        require_once(POWERPRESS_ABSPATH . '/powerpressadmin-auth.class.php');
        $auth = new PowerPressAuth();

        if (!empty($Settings['disable_dashboard_stats']))
            return; // Lets not do anythign to the dashboard for PowerPress Statistics

        // If using user capabilities...
        if (!empty($Settings['use_caps']) && !current_user_can('view_podcast_stats'))
            return;

        $updating = false;
        $UserPass = (!empty($Settings['blubrry_auth']) ? $Settings['blubrry_auth'] : '');
        $Keyword = (!empty($Settings['blubrry_program_keyword']) ? $Settings['blubrry_program_keyword'] : '');
        $StatsCached = get_option('powerpress_stats');
        if (empty($StatsCached))
            $StatsCached = array();
        if (!empty($StatsCached['content']))
            $this->content = $StatsCached['content'];
        //If we have an error or no data, set the updated timestamp to 1 so that we call the API
        if (empty($StatsCached['updated']) || isset($StatsCached['content']['error']) || empty($StatsCached['content']['day_total_data']))
            $StatsCached['updated'] = 1; // Some time

        // If no content or it's been over 3 hours...
        if (!empty($Settings['network_mode'])) {
            $this->content = array();
            $this->content['error'] = 'Multi-program mode is enabled, please visit <a href="https://stats.blubrry.com/" target="_blank">Blubrry.com</a> to see your statistics';
        } //logged in but no program selected
        else if (empty($Keyword) && (($creds || $UserPass) && time() > ($StatsCached['updated'] + (60 * 60 * 3)))) {
            $this->content = array();
            $this->content['error'] = "No program selected. Please visit <a href=\"https://stats.blubrry.com/\" target=\"_blank\">Blubrry.com</a> to see your statistics";
        } else if ($creds  && time() > ($StatsCached['updated'] + (60 * 60 * 3))) {
            $updating = true;
            $accessToken = powerpress_getAccessToken();
            $req_url = sprintf('/2/stats/%s/widget/preview.json', $Keyword);
            $req_url .= (defined('POWERPRESS_BLUBRRY_API_QSA') ? '?' . POWERPRESS_BLUBRRY_API_QSA : '');
            $new_content = $auth->api($accessToken, $req_url, false, false, 2, true);
        } else if ($UserPass && time() > ($StatsCached['updated'] + (60 * 60 * 3))) {
            $updating = true;
            $success = false;
            $api_url_array = powerpress_get_api_array();
            foreach ($api_url_array as $index => $api_url) {
                $req_url = sprintf('%s/stats/%s/widget/preview.json', rtrim($api_url, '/'), $Keyword);
                $req_url .= (defined('POWERPRESS_BLUBRRY_API_QSA') ? '&' . POWERPRESS_BLUBRRY_API_QSA : '');

                $json_data = powerpress_remote_fopen($req_url, $UserPass, array(), 2); // Only give this 2 seconds to return results
                if (!$json_data && $api_url == 'https://api.blubrry.com/') { // Lets force cURL and see if that helps...
                    $json_data = powerpress_remote_fopen($req_url, $UserPass, array(), 2, false, true); // Only give this 2 seconds to return results
                }
                if ($json_data != false)
                    break;
            }
            if (isset($json_data) && $json_data) {
                $new_content = powerpress_json_decode($json_data);
            } else {
                $new_content = false;
            }
        } else if (!$UserPass && !$creds) {
            $this->content = array();
            $this->content['error'] = "<div class='blubrry-stats-marketing-message'>";
            $this->content['error'] .= "<h2 class='blubrry-stats-marketing-text'>Free Podcast Statistics</h2>";
            $this->content['error'] .= "<h4 class='blubrry-stats-marketing-text'>View a summary of your Blubrry statistics right here in PowerPress.</h4>";

            $this->content['error'] .= "<a class='blubrry-stats-marketing-text' href='https://blubrry.com/support/statistics-documentation/basic-statistics/' target='_blank'>";
            $this->content['error'] .= "<div class='pp_white-button-container'><h5 class='blubrry-stats-marketing-text'>";
            $this->content['error'] .= __('LEARN MORE', 'powerpress');
                $this->content['error'] .= "</h5></div></a>";
            $this->content['error'] .= "</div>";
        }
        //No need for an else block--later checks on $this->content, $updating, and $this->content['error'] cover all needed cases

        if (empty($this->content)) {
            $this->content['error'] = __('Error: A network or authentication error occurred.') . ' <a href="https://blubrry.com/support/powerpress-documentation/services-stats/" target="_blank">' . __('Click Here For Help', 'powerpress') . '</a>' ;
        }

        //If we've just called the API, we're need to update the cached stats content
        if ($updating) {
            //Check for errors from the API
            if (!isset($new_content) || !$new_content) {
                $this->content['error'] = 'Unable to retrieve statistics';
                $success = false;
            } elseif (isset($new_content['error'])) {
                $this->content['error'] = $new_content['error'];
                $success = false;
            } else {
                $this->content = $new_content;
                update_option('powerpress_stats', array('updated' => time(), 'content' => $new_content));
                $success = true;
            }

            if ($success == false) {
                if (empty($StatsCached['retry_count']))
                    $StatsCached['retry_count'] = 1;
                else if ($StatsCached['retry_count'] < 24)
                    $StatsCached['retry_count']++;

                if ($StatsCached['retry_count'] > 12) // After 36 hours, if we keep failing to authenticate then lets clear the data and display the authentication notice.
                {
                    $this->content['error'] = __('Error: A network or authentication error occurred.') . ' <a href="https://blubrry.com/support/powerpress-documentation/services-stats/" target="_blank">' . __('Click Here For Help', 'powerpress') . '</a>' ;
                }
                // Update the updated flag so it will not try again for 3 hours...
                update_option('powerpress_stats', array('updated' => time(), 'content' => $this->content, 'retry_count' => $StatsCached['retry_count']));
            }
        }

        ?>
        <?php
    }

    function powerpress_print_stats_widget()
    {
        echo "<div>";
            if (isset($this->content['error'])) {
                echo $this->content['error'];
            } else {
                echo "<div id='pp-blubrry-stats-widget' style='height:500px; width: 100%;'>";
                $this->powerpress_dashboard_stats_js();
                $this->powerpress_dashboard_stats_html();
                $this->powerpress_dashboard_stats_summary();
                echo "</div>";
            }
        echo "</div>";
    }

    /**
     * Prints the HTML and CSS code for the right hand column of the Blubrry Stats Widget
     */
    function powerpress_dashboard_stats_summary()
    {
        ?>
        <style>
            .blubrry-stats-summary {
                display: inline-block;
                width: 100%;
                vertical-align: top;
                height: 250px;
                float: right;
            }

            .blubrry-stats-summary-label {
                color: #252733;
                font-weight: bold;
                text-align: left;
                border: none;
                font-size: 100%;
            }

            .blubrry-stats-summary-data {
                color: #003366;
                text-align: right;
                font-weight: bold;
                border: none;
                font-size: 100%;
            }

            .blubrry-stats-summary-item-first .blubrry-stats-summary-data {
                color: #B347A3;
            }

            .blubrry-stats-summary-table {
                height: 70%;
                width: 95%;
                float: right;
                background-color: white;
                border: none;
                border-radius: 0;
            }

            .blubrry-stats-summary-item {
                border-top: 1px solid #F1F1F5;
            }

            .blubrry-advanced-link-styling {
                display: inline-block;
                background-color: #EEF0FF;
                height: 40px;
                line-height: 40px;
                border-radius: 20px;
                color: #0B43A4;
                width: 95%;
                text-align: center;
                vertical-align: center;
                float: right;
                font-size: 90%;
                font-weight: bold;
            }

            .blubrry-stats-summary-icon {
                display: inline-block;
                margin-left: 8px;
                vertical-align: middle;
            }
        </style>
        <div class="blubrry-stats-summary" id="pp-blubrry-stats-summary">
            <table class="blubrry-stats-summary-table">
                <tr class="blubrry-stats-summary-item-first">
                    <td class="blubrry-stats-summary-label">Today</td>
                    <?php
                    $today_total = isset($this->content['day_total_data'][6]['trending_day_total']) ? $this->content['day_total_data'][6]['trending_day_total'] : 0;
                    if ($today_total < $this->content['day_total_data'][5]['trending_day_total']) {
                        $day_img_src = powerpress_get_root_url() . 'images/down_arrow_pink.svg';
                        $day_change_text = "Decreased from yesterday";
                    } elseif (!isset($this->content['day_total_data'][5]['trending_day_total']) || $today_total > $this->content['day_total_data'][5]['trending_day_total']) {
                        $day_img_src = powerpress_get_root_url() . 'images/up_arrow_pink.svg';
                        $day_change_text = "Increased from yesterday";
                    } else {
                        $day_img_src = powerpress_get_root_url() . 'images/audio_lines_pink.svg';
                        $day_change_text = "Unchanged from yesterday";
                    } ?>
                    <td class="blubrry-stats-summary-data"
                        aria-label="<?php echo $today_total . " downloads today. $day_change_text"; ?>">
                        <?php echo $today_total; ?>
                        <div class="blubrry-stats-summary-icon" title="<?php echo $day_change_text; ?>">
                            <img alt="today" src="<?php echo $day_img_src; ?>"/>
                        </div>
                    </td>
                </tr>
                <tr class="blubrry-stats-summary-item">
                    <td class="blubrry-stats-summary-label">30 day average</td>
                    <?php
                    if ($this->content['month_average_change'] == 'up') {
                        $month_img_src = powerpress_get_root_url() . 'images/up_arrow.svg';
                        $month_change_text = "Increased from last month";
                    } elseif ($this->content['month_average_change'] == 'down') {
                        $month_img_src = powerpress_get_root_url() . 'images/down_arrow.svg';
                        $month_change_text = "Decreased from last month";
                    } else {
                        $month_img_src = powerpress_get_root_url() . 'images/audio_lines.svg';
                        $month_change_text = "Unchanged from last month";
                    } ?>
                    <td class="blubrry-stats-summary-data"
                        aria-label="<?php echo $this->content['month_average'] . " average downloads for the past month. $month_change_text"; ?>">
                        <?php echo $this->content['month_average']; ?>
                        <div class="blubrry-stats-summary-icon" title="<?php echo $month_change_text; ?>">
                            <img alt="month change" src="<?php echo $month_img_src; ?>"/>
                        </div>
                    </td>
                </tr>
                <tr class="blubrry-stats-summary-item">
                    <td class="blubrry-stats-summary-label">Total</td>
                    <?php
                    if ($this->content['day_total_data'][6]['trending_day_total'] > 0) {
                        $total_img_src = powerpress_get_root_url() . 'images/up_arrow.svg';
                        $total_change_text = "Increased from yesterday";
                    } else {
                        $total_img_src = powerpress_get_root_url() . 'images/audio_lines.svg';
                        $total_change_text = "Unchanged from yesterday";
                    }
                    ?>
                    <td class="blubrry-stats-summary-data"
                        aria-label="<?php echo $this->content['program_total'] . " total downloads for program. $total_change_text"; ?>">
                        <?php echo $this->content['program_total']; ?>
                        <div class="blubrry-stats-summary-icon" title="<?php echo $total_change_text; ?>">
                            <img alt="total" src="<?php echo $total_img_src; ?>"/>
                        </div>
                    </td>
                </tr>
            </table>
            <a id="blubrry-advanced-link" href="https://stats.blubrry.com/stats/s-<?php echo $this->content['stats_prog_id']; ?>/"
               target="_blank">
                <div class="blubrry-advanced-link-styling">
                    See all statistics
                </div>
            </a>
        </div>
        <?php
    }

    /**
     * Prints the JavaScript code for drawing the graph in the Blubrry Stats Widget
     *
     * @param $this->content['day_total_data'] array
     * @param $this->content['scale_min'] int
     * @param $this->content['scale_max'] int
     * @param $this->content['scale_step'] int
     */
    function powerpress_dashboard_stats_js()
    {
        ?>

        <script>
            function drawLine(ctx, startX, startY, endX, endY, color) {
                ctx.save();
                ctx.strokeStyle = color;
                ctx.beginPath();
                ctx.moveTo(startX, startY);
                ctx.lineTo(endX, endY);
                ctx.closePath();
                ctx.stroke();
                ctx.restore();
            }

            function drawBar(ctx, upperLeftCornerX, upperLeftCornerY, width, height, color) {
                ctx.save();
                ctx.fillStyle = color;
                ctx.fillRect(upperLeftCornerX, upperLeftCornerY, width, height);
                ctx.restore();
                //added 1 here to avoid a white sliver between the rectangle and half circle
                drawArc(ctx, upperLeftCornerX, upperLeftCornerY + 1, width, height, color);
            }

            function drawArc(ctx, upperLeftCornerX, upperLeftCornerY, width, height, color) {
                ctx.save();
                ctx.fillStyle = color;
                let radius = width / 2;
                let centerX = upperLeftCornerX + radius;
                ctx.beginPath();
                ctx.arc(centerX, upperLeftCornerY, radius, 0, Math.PI, true);
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            }


            window.addEventListener('load', (event) => {

                //First, check the width of the widget and style our containers accordingly
                let canvas = document.getElementById("blubrry-stats-widget-canvas");
                let total_widget_width = canvas.parentElement.parentElement.parentElement.clientWidth;

                //date_width approximately 1/7 the total width, adjusted with guess & check
                let date_width = .132;
                if (total_widget_width >= 430 && total_widget_width < 500) {
                    date_width = .134;
                } else if (total_widget_width >= 500 && total_widget_width < 550) {
                    date_width = .136;
                } else if (total_widget_width >= 550 && total_widget_width < 750) {
                    date_width = .137;
                } else if (total_widget_width >= 750) {
                    canvas.parentElement.parentElement.style.width = "66%";
                    document.getElementById('pp-blubrry-stats-summary').style.width = "28%";
                    document.getElementById('pp-blubrry-stats-summary').style.margin = "3ch 4ch 0 0";
                    document.getElementById('pp-blubrry-stats-widget').style.height = "260px";
                    if (total_widget_width >= 1050) {
                        date_width = .1373;
                    } else {
                        date_width = .136;
                    }
                }
                //Initialize the drawing context and set the dimensions of the graph
                let ctx = canvas.getContext("2d");
                let canvas_height = canvas.parentElement.clientHeight;
                let canvas_width = canvas.parentElement.clientWidth;
                ctx.canvas.width = canvas_width;
                ctx.canvas.height = canvas_height;
                //Draw the left border
                drawLine(ctx, 0, 0, 0, canvas_height, '#B0BEC5');
                //Draw the scale lines
                let scale_container = document.getElementById("blubrry-stats-chart-scale");
                let new_node;
                <?php
                $numLines = ($this->content['scale_max'] - $this->content['scale_min']) / $this->content['scale_step'];
                for ($x = 0; $x < $numLines; $x++) { ?>
                new_node = document.createElement("div");
                new_node.style.height = 'calc((100% + 5px) / <?php echo $numLines; ?>';
                new_node.innerHTML = '<?php echo $this->content['scale_min'] + ($x + 1) * $this->content['scale_step']; ?>';
                scale_container.prepend(new_node);
                drawLine(ctx, 0, <?php echo $x; ?> * canvas_height / <?php echo $numLines; ?>, canvas_width, <?php echo $x; ?> *
                canvas_height / <?php echo $numLines; ?>, '#F1F1F5'
            )
                ;
                <?php } ?>

                //Move the x-scale over the width of the y-scale
                let all_dates = document.getElementById("blubrry-stats-widget-dates");
                all_dates.style.marginLeft = scale_container.offsetWidth + "px";

                //Draw the histogram bars
                let bar_width = 20;
                let date_container, value_input;
                let positionX, positionY, bar_height, subtract_min_scale,
                    scale_range = <?php echo $this->content['scale_max'] - $this->content['scale_min']; ?>;

                // Create gradient for histogram bars
                var grd = ctx.createLinearGradient(0, 0, 0, canvas_height);
                grd.addColorStop(0, "#C26BB5");
                grd.addColorStop(1, "#86357A");

                <?php foreach ($this->content['day_total_data'] as $index => $day_data) {
                if ($index < 7) {?>
                //To get x position, we basically want to divide the width into 14 segments and choose only odd
                // number index segments
                positionX = canvas_width / 14 + <?php echo $index; ?> * 2 * canvas_width / 14 - bar_width / 2;

                //For y position, start by determining what portion of the scale the bar should reach, multiply it
                // by the canvas height, and subtract the arc radius
                subtract_min_scale = <?php echo $day_data['trending_day_total'] - $this->content['scale_min']; ?>;
                bar_height = canvas_height * subtract_min_scale / scale_range - bar_width / 2;
                //Because the 0 value is at the top of the canvas , our start y-pos needs to be
                // canvas_height - bar_height
                positionY = canvas_height - bar_height;
                <?php if ($day_data['trending_day_total'] > 0) { ?>
                drawBar(ctx, positionX, positionY, bar_width, bar_height, grd);
                <?php } ?>

                //Put the value above the bar
                value_input = document.getElementById("blubrry-stats-value-<?php echo $index; ?>");
                value_input.value = '<?php echo $day_data['trending_day_total']; ?>';
                value_input.style.bottom = (bar_height + bar_width + 20) + "px";
                value_input.style.left = (positionX - 9 - <?php echo $index; ?> * 40) + "px";
                value_input.setAttribute('aria-label', '<?php echo $day_data['trending_day_total'] . " downloads on " . Date("l M d", strtotime($day_data['day_date'])); ?>');
                //Need a smaller font if the number is 4 or more digits--won't fit in width of 35px
                <?php if ($day_data['trending_day_total'] > 999) { ?>
                value_input.style.fontSize = "80%";
                <?php } ?>
                //Value for today should be pink
                if (<?php echo $index; ?> == 6
            )
                {
                    value_input.style.color = "#B347A3";
                }

                //Put the date below the bar
                date_container = document.getElementById("blubrry-stats-date-<?php echo $index; ?>");
                date_container.innerHTML = '<?php echo Date("D d", strtotime($day_data['day_date'])); ?>';
                date_container.style.width = date_width * canvas_width + "px";
                <?php }
                } ?>

            });
        </script>
        <?php
    }

    /**
     * Prints the HTML and CSS code for the graph on the left side of the Blubrry Stats Widget
     *
     * @param $this->content['widget_title'] string
     */
    function powerpress_dashboard_stats_html()
    {
        ?>
        <style>
            .blubrry-stats-seven-day {
                display: inline-block;
                width: 100%;
                height: 250px;
                padding: 1vh;
            }

            #blubrry-stats-widget-dates {
                padding-left: 5px;
            }

            div[id^="blubrry-stats-date-"] {
                display: inline-block;
                text-align: center;
                color: #444444;
                font-size: 85%;
                font-weight: bold;
                position: relative;
                bottom: 20px;
            }

            input[id^="blubrry-stats-value-"][type="text"] {
                width: 35px;
                z-index: 101;
                position: relative;
                display: inline-block;
                font-weight: bold;
                color: #444444;
                padding: 0;
                border: none;
            }

            #blubrry-stats-chart-scale {
                display: inline-block;
                height: calc(100% - 65px);
                vertical-align: top;
                color: #444444;
                font-size: 85%;
            }

            .blubrry-stats-chart-label-container {
                width: calc(100% - 30px);
                height: calc(100% - 65px);
                display: inline-block;
                margin-top: 12px;
            }

            .blubrry-stats-chart-label-container input {
                text-align: center;
                background: transparent;
                border: none;
                font-size: 110%;
            }

            .blubrry-stats-chart-title {
                color: #252733;
                font-weight: bold;
                font-size: 13px;
                margin: 0 0 1em 0;
            }
        </style>
        <div class="blubrry-stats-seven-day">
            <h6 class="blubrry-stats-chart-title"><?php echo $this->content['widget_title']; ?></h6>
            <div id="blubrry-stats-chart-scale">
            </div>
            <div class="blubrry-stats-chart-label-container">
                <canvas id="blubrry-stats-widget-canvas">
                </canvas>
                <input id="blubrry-stats-value-0" type="text" aria-label="" disabled/>
                <input id="blubrry-stats-value-1" type="text" aria-label="" disabled/>
                <input id="blubrry-stats-value-2" type="text" aria-label="" disabled/>
                <input id="blubrry-stats-value-3" type="text" aria-label="" disabled/>
                <input id="blubrry-stats-value-4" type="text" aria-label="" disabled/>
                <input id="blubrry-stats-value-5" type="text" aria-label="" disabled/>
                <input id="blubrry-stats-value-6" type="text" aria-label="" disabled/>
            </div>

            <div id="blubrry-stats-widget-dates">
                <div id="blubrry-stats-date-0"></div>
                <div id="blubrry-stats-date-1"></div>
                <div id="blubrry-stats-date-2"></div>
                <div id="blubrry-stats-date-3"></div>
                <div id="blubrry-stats-date-4"></div>
                <div id="blubrry-stats-date-5"></div>
                <div id="blubrry-stats-date-6"></div>
            </div>
        </div>

        <?php
    }
}