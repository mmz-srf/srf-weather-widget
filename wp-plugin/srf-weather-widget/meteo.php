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
            'geolocation' => get_option(SrfWeatherWidgetSettings::DEFAULT_LOCATION),
            'locationname' => get_option(SrfWeatherWidgetSettings::DEFAULT_LOCATION_NAME),
        ],
        array_change_key_case( (array) $atts, CASE_LOWER ),
        $tag
    );

    if (false === in_array($widgetAtts['size'], ['S', 'M', 'L'])) {
        return 'Not a valid widget size set.';
    }

    // generate basic auth token
    $key = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY);
    $secret = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET);
    $encoded = base64_encode($key.':'.$secret);

    $apiDomain = 'https://api.srgssr.ch';
    $apiBaseUrl = $apiDomain.'/srf-meteo/v2';


    // login
    $response = wp_remote_post(
        $apiDomain.'/oauth/v1/accesstoken?grant_type=client_credentials',
        [
            'headers' => [
                'Authorization' => 'Basic '.$encoded,
                'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
            ],
        ]
    );
    $body = json_decode(wp_remote_retrieve_body($response), true);
    $accessToken = $body['access_token'];


    // search by name
    $response = get_transient('srf_weather_geolocation_names');
    if (false === $response) {
        $response = wp_remote_get(
            $apiBaseUrl . '/geolocationNames?zip=8600',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]
        );
        set_transient('srf_weather_geolocation_names', $response, 60 * 60);
    }
    $body = json_decode(wp_remote_retrieve_body($response), true);
    $geolocationId = $body['geolocation']['id'];


    // get forecast data
    $response = get_transient('srf_weather_forecastpoint');
    if (false === $response) {
        $response = wp_remote_get(
            $apiBaseUrl . '/forecastpoint/' . $geolocationId,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]
        );
        set_transient('srf_weather_forecastpoint', $response, 60 * 60);
    }
    $forecastpoint = wp_remote_retrieve_body($response);


    return
        '<div class="srf-weather-widget" 
            data-size="'.esc_html($widgetAtts['size']).'" 
            data-geolocation="'.esc_html($widgetAtts['geolocation']).'" 
            data-location-name="'.esc_html($widgetAtts['locationname']).'" 
            data-mode="'.esc_html($widgetAtts['mode']).'" 
            data-forecast-point=\''.$forecastpoint.'\'>
        </div>';
}

// add backend styles
function srf_weather_widget_styles() {
    wp_enqueue_style('srf_weather_widget', plugins_url('css/srf_weather_widget_backend_options.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'srf_weather_widget_styles');
add_action( 'wp_head', 'meteo_resources' );
add_shortcode('meteo', 'meteo_widget'); // add your code.

// handle installation and backend Hooks
new SrfWeatherWidgetSettings();
new SrfWeatherWidgetInstallation();
