<?php

/**
 * Plugin Name: Custom Ad Block
 * Author: Rafael Zufi Leite
 * Description: Custom ad block plugin.
 * Version: 1.0.0
 */

// Enqueue editor assets
function loadCustomAdBlock() {
  wp_enqueue_script(
    'custom-ad-block-script',
    plugin_dir_url(__FILE__) . '/assets/js/custom-ad-block.js',
    array('wp-blocks', 'wp-i18n', 'wp-editor'),
    true
  );
  wp_enqueue_style(
    'custom-ad-block-style',
    plugin_dir_url(__FILE__) . '/assets/css/style.css',
    array('wp-blocks', 'wp-i18n', 'wp-editor'),
    true
  );
}
add_action('enqueue_block_editor_assets', 'loadCustomAdBlock');

// Enqueue frontend assets
function loadCustomAdBlockFrontend() {
  wp_enqueue_style(
    'custom-ad-block-style',
    plugin_dir_url(__FILE__) . '/assets/css/style.css',
    array(),
    true
  );
}
add_action('wp_enqueue_scripts', 'loadCustomAdBlockFrontend');

// Block output
function customAdBlockOutput($props) {
  $adType = $props['adType'];
  $template = $props['template'];
  $title = $props['title'];
  $backgroundColor = $props['backgroundColor'];
  $countdownDate = $props['countdownDate'] ? $props['countdownDate'] : date("Y-m-d");
  // Checks if is post and assign the default background colors
  if (is_single()) {
    switch (get_the_category()[0]->slug) {
      case 'nfl':
        $backgroundColor = '#000000';
        break;
      case 'nba':
        $backgroundColor = '#FFA500';
        break;
      case 'mlb':
        $backgroundColor = '#0000FF';
        break;
      default:
        break;
    }
  }
  if ($adType == 'pick') {
    if ($template == 'pick') {
      return '<div class="custom-ad-block-container ad-type-' . $adType . '" style="background-color: ' . $backgroundColor . '">
              <div class="ad-left-section">
                <img src="' . plugin_dir_url(__FILE__) . '/assets/img/nfl.png" />
              </div>
              <div class="ad-middle-section">
                <div class="ad-countdown">
                  <div class="ad-countdown-square ad-countdown-days">
                    <div class="ad-countdown-square-text">DAYS</div>
                    <div class="ad-countdown-square-number" id="countdown-time-days">01</div>
                  </div>
                  <div class="ad-countdown-square ad-countdown-hours">
                    <div class="ad-countdown-square-text">HOURS</div>
                    <div class="ad-countdown-square-number" id="countdown-time-hours">23</div>
                  </div>
                  <div class="ad-countdown-square ad-countdown-minutes">
                    <div class="ad-countdown-square-text">MIN</div>
                    <div class="ad-countdown-square-number" id="countdown-time-minutes">55</div>
                  </div>
                  <div class="ad-countdown-square ad-countdown-seconds">
                    <div class="ad-countdown-square-text">SEC</div>
                    <div class="ad-countdown-square-number" id="countdown-time-seconds">32</div>
                  </div>
                  <div class="ad-countdown-remaining">
                    <div class="ad-countdown-remaining-text">Remaining Time To Place Bet</div>
                  </div>
                </div>
                <div class="ad-title">
                  <div class="ad-main-title">'
                  . $title .
                  '</div>
                  <div class="ad-sub-title">
                    Hurry up! <b>25</b> people have placed this bet
                  </div>
                </div>
              </div>
              <div class="ad-right-section">
                <button class="bet-and-win-btn" href="#">BET & WIN</button>
                <p>Trusted Sportsbetting.ag</p>
              </div>
            </div>
            <script>
            var countDownDate = new Date("' . $countdownDate . '").getTime();
            var x = setInterval(function() {
              var now = new Date().getTime();
              var distance = countDownDate - now;
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);
              document.getElementById("countdown-time-days").innerHTML = days;
              document.getElementById("countdown-time-hours").innerHTML = hours;
              document.getElementById("countdown-time-minutes").innerHTML = minutes;
              document.getElementById("countdown-time-seconds").innerHTML = seconds;
              if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown-time-days").innerHTML = "0";
                document.getElementById("countdown-time-hours").innerHTML = "0";
                document.getElementById("countdown-time-minutes").innerHTML = "0";
                document.getElementById("countdown-time-seconds").innerHTML = "0";
              }
            }, 1000);
            </script>';
    }
    // TODO: other pick templates
    else {
      return '<div class="custom-ad-block-container ad-type-' . $adType . '" style="background-color: ' . $backgroundColor . '">
              Type: pick
              Template: default
            </div>';
    }
  }
  // TODO: other ad types
  else {
    if ($template == 'pick') {
      return '<div class="custom-ad-block-container ad-type-' . $adType . '" style="background-color: ' . $backgroundColor . '">
              Type: default
              Template: pick
            </div>';
    }
    else {
      return '<div class="custom-ad-block-container ad-type-' . $adType . '" style="background-color: ' . $backgroundColor . '">
              Type: default
              Template: default
            </div>';
    }
  }
}
// Register block
register_block_type('rzufil/custom-ad-block', array(
  'render_callback' => 'customAdBlockOutput',
));

// Register block meta
function registerCustomAdBlockMeta() {
  register_meta('post', 'color', array('show_in_rest' => true, 'type' => 'string', 'single' => true));
}
add_action('init', 'registerCustomAdBlockMeta');