<?php
/**
 * @package Meteo Widget
 */
/*
Plugin Name: Meteo
*/



// Now we set that function up to execute when the admin_notices action is called.

// We need some CSS to position the paragraph.
function meteo_resources() {
    echo '<script src="https://mmz-srf.github.io/srf-weather-widget/assets/index-fd0920e5.js" type="text/javascript"></script>';
    echo '<link rel="stylesheet" href="https://mmz-srf.github.io/srf-weather-widget/assets/index-4a6b12fb.css">';
}

function meteo_widget() {
    return '<div id="main" class="main"></div>';
}

add_action( 'wp_head', 'meteo_resources' );
add_shortcode('meteo', 'meteo_widget'); // add your code.