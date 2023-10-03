<?php

class SrfWeatherWidgetApiClient
{
    public static function getAccessToken($key, $secret)
    {
        $encoded = base64_encode($key . ':' . $secret);
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
        // todo: store?
        return $body['access_token'];
    }

    public static function getGeolocationNames($geolocationName, $accessToken) {
        // search by name
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
            return json_decode(wp_remote_retrieve_body($response), true);;
        }
    }

    public static function getForecastData($geolocationId, $accessToken)
    {
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
        return  wp_remote_retrieve_body($response);
    }
}