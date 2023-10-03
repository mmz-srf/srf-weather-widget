<?php
/**
 * @package SRF Weather Widget
 *
 * Plugin Name: SRF Weather Widget
*/

require_once __DIR__ . '/SrfWeatherWidgetSettings.php';
require_once __DIR__ . '/SrfWeatherWidgetInstallation.php';

const WIDGET_BASE_URL = 'https://mmz-srf.github.io/srf-weather-widget';
const WIDGET_SIZES = ['S', 'M', 'L'];
const API_DOMAIN = 'https://api.srgssr.ch';
const API_BASE_URL = API_DOMAIN . '/srf-meteo/v2';
const CACHE_TTL = 60; // seconds
const REQUEST_TIMEOUT = 2; // seconds

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
        $encoded = base64_encode($key . ':' . $secret);

        // login
        $response = wp_remote_post(
            API_DOMAIN . '/oauth/v1/accesstoken?grant_type=client_credentials',
            [
                'headers' => [
                    'Authorization' => 'Basic ' . $encoded,
                    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ],
                'timeout' => REQUEST_TIMEOUT,
            ]
        );
        $body = json_decode(wp_remote_retrieve_body($response), true);
        $accessToken = $body['access_token'];

        $geolocationId = $widgetAtts['geolocation'];

        if (empty($geolocationId)) {
            // search by name
            $geolocationName = $widgetAtts['locationname'];
            $cacheKey = hash('sha256', $geolocationName);
            $response = get_transient('srf_weather_geolocation_names_' . $cacheKey);
            if (false === $response) {
                $response = wp_remote_get(
                    API_BASE_URL . '/geolocationNames?name=' . $geolocationName,
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken,
                        ],
                        'timeout' => REQUEST_TIMEOUT,
                    ]
                );
                set_transient('srf_weather_geolocation_names_' . $cacheKey, $response, CACHE_TTL);
            }
            $body = json_decode(wp_remote_retrieve_body($response), true);
            $geolocationId = $body['geolocation']['id'];
        }

        // get forecast data
        $cacheKey = hash('sha256', $geolocationId);
        $response = get_transient('srf_weather_forecastpoint_' . $cacheKey);
        if (false === $response) {
            $response = wp_remote_get(
                API_BASE_URL . '/forecastpoint/' . $geolocationId,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                    'timeout' => REQUEST_TIMEOUT,
                ]
            );
            set_transient('srf_weather_forecastpoint_' . $cacheKey, $response, CACHE_TTL);
        }
        $forecastpoint = wp_remote_retrieve_body($response);
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
add_action( 'wp_head', 'meteo_resources' );
add_shortcode('meteo', 'meteo_widget'); // add your code.

// handle installation and backend Hooks
new SrfWeatherWidgetSettings();
new SrfWeatherWidgetInstallation();
