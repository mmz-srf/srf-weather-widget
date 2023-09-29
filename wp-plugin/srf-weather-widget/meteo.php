<?php
/**
 * @package Meteo Widget
 */
/*
Plugin Name: Meteo
*/

include __DIR__ . '/SrfWeatherWidgetSettings.php';

new SrfWeatherWidgetSettings();

// We need some CSS to position the paragraph.
function meteo_resources() {
    echo '<script src="https://mmz-srf.github.io/srf-weather-widget/index.js" type="module"></script>';
    echo '<link rel="stylesheet" href="https://mmz-srf.github.io/srf-weather-widget/index.css">';
}

function meteo_widget() {
    return '<div class="srf-weather-widget"></div>';
}

add_action( 'wp_head', 'meteo_resources' );
add_shortcode('meteo', 'meteo_widget'); // add your code.

// add default settings

