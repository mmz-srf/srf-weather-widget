<?php
/**
 * @package SRF Weather Widget
 *
 * Plugin Name: SRF Weather Widget
*/

require_once __DIR__ . '/SrfWeatherWidgetSettings.php';
require_once __DIR__ . '/SrfWeatherWidgetInstallation.php';

// We need some CSS to position the paragraph.
function meteo_resources() {
    echo '<script src="https://mmz-srf.github.io/srf-weather-widget/index.js" type="module"></script>';
    echo '<link rel="stylesheet" href="https://mmz-srf.github.io/srf-weather-widget/index.css">';
}

function meteo_widget($atts = [], $content = null, $tag = '') {
    $widgetAtts = shortcode_atts(
        [
            'size' => 'S',
            'geolocation' => '',
            'locationname' => '',
        ],
        array_change_key_case( (array) $atts, CASE_LOWER ),
        $tag
    );

    if (false === in_array($widgetAtts['size'], ['S', 'M', 'L'])) {
        return 'Not a valid widget size set.';
    }

    $key = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY);
    $secret = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET);
    $commentedKeys = '<!-- api-key: ' .$key.' api secret:' . $secret . ' -->';

    $encoded = base64_encode($key.':'.$secret);
    // TODO: send request for data and add it to data attribute


    return
        $commentedKeys .
        '<div class="srf-weather-widget" 
        data-size="'.esc_html($widgetAtts['size']).'" 
        data-geolocation="'.esc_html($widgetAtts['geolocation']).'" 
        data-location-name="'.esc_html($widgetAtts['locationname']).'"></div>';
}

add_action( 'wp_head', 'meteo_resources' );
add_shortcode('meteo', 'meteo_widget'); // add your code.

// handle installation and backend Hooks
new SrfWeatherWidgetSettings();
new SrfWeatherWidgetInstallation();
