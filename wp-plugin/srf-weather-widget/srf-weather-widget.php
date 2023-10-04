<?php
/*
 * Plugin Name: SRF Weather Widget
 * Plugin URI:  https://mmz-srf.github.io/srf-weather-widget/
 * Description: Add SRF Weather Widget to your posts or theme.
*/

require_once __DIR__ . '/SrfWeatherWidgetSettings.php';
require_once __DIR__ . '/SrfWeatherWidgetInstallation.php';
require_once __DIR__ . '/SrfWeatherWidgetApiClient.php';

const WIDGET_BASE_URL = 'https://mmz-srf.github.io/srf-weather-widget';
const WIDGET_SIZES = ['S', 'M', 'L'];


// We need some CSS to position the paragraph.
function meteo_resources() {
    echo '<script src="' . WIDGET_BASE_URL . '/index.js" type="module"></script>';
    echo '<link rel="stylesheet" href="' . WIDGET_BASE_URL . '/index.css">';
}

function meteo_widget($atts = [], $content = null, $tag = '') {
    $widgetAtts = shortcode_atts(
        [
            'size' => 'S',
            'mode' => 'hours',
            'geolocation' => get_option(SrfWeatherWidgetSettings::DEFAULT_LOCATION),
            'locationname' => get_option(SrfWeatherWidgetSettings::DEFAULT_LOCATION_NAME),
        ],
        array_change_key_case( (array) $atts, CASE_LOWER ),
        $tag
    );

    if (false === in_array($widgetAtts['size'], WIDGET_SIZES)) {
        return 'Not a valid widget size set.';
    }


    // generate basic auth token
    $key = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY);
    $secret = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET);

    if (!empty($key) && !empty($secret)) {

        // login
        $accessToken = SrfWeatherWidgetApiClient::getAccessToken($key, $secret);
        $geolocationId = $widgetAtts['geolocation'];

        if (empty($geolocationId)) {
            // search by name
            $geolocationName = $widgetAtts['locationname'];
            $body = SrfWeatherWidgetApiClient::getGeolocationNames($geolocationName, $accessToken);
            $geolocationId = $body[0]['geolocation']['id'];
        }

        $forecastpoint = SrfWeatherWidgetApiClient::getForecastData($geolocationId, $accessToken);
    }

    $widget = '<div class="srf-weather-widget" data-size="' . esc_html($widgetAtts['size']) . '" data-mode="' . esc_html($widgetAtts['mode']) . '"';

    if (!empty($widgetAtts['geolocation'])) {
        $widget .= ' data-geolocation="' . esc_html($widgetAtts['geolocation']) . '"';
    }

    if (!empty($widgetAtts['locationname'])) {
        $widget .= ' data-location-name="' . esc_html($widgetAtts['locationname']) . '"';
    }

    if (!empty($forecastpoint)) {
        $widget .= ' data-forecast-point=\'' . $forecastpoint . '\'';
    }

    $widget .= '></div>';

    return $widget;
}

// add backend styles
function srf_weather_widget_styles() {
    wp_enqueue_style('srf_weather_widget', plugins_url('css/srf_weather_widget_backend_options.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'srf_weather_widget_styles');
add_action('wp_head', 'meteo_resources');
add_shortcode('meteo', 'meteo_widget'); // add your code.
