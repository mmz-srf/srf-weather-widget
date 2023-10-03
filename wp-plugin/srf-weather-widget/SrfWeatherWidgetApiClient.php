<?php

class SrfWeatherWidgetApiClient
{
    const API_DOMAIN = 'https://api.srgssr.ch';
    const API_BASE_URL = self::API_DOMAIN . '/srf-meteo/v2';
    const CACHE_TTL = 60; // seconds
    const REQUEST_TIMEOUT = 2; // seconds

    public static function getAccessToken($key, $secret)
    {
        $encoded = base64_encode($key . ':' . $secret);
        $response = wp_remote_post(
            self::API_DOMAIN . '/oauth/v1/accesstoken?grant_type=client_credentials',
            [
                'headers' => [
                    'Authorization' => 'Basic ' . $encoded,
                    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ],
                'timeout' => self::REQUEST_TIMEOUT,
            ]
        );
        $body = json_decode(wp_remote_retrieve_body($response), true);

        return $body['access_token'];
    }

    public static function getGeolocationNames($geolocationName, $accessToken) {
        // search by name
        $cacheKey = hash('sha256', $geolocationName);
        $response = get_transient('srf_weather_geolocation_names_' . $cacheKey);
        if (false === $response) {
            $response = wp_remote_get(
                self::API_BASE_URL . '/geolocationNames?name=' . $geolocationName,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                    'timeout' => self::REQUEST_TIMEOUT,
                ]
            );
            set_transient('srf_weather_geolocation_names_' . $cacheKey, $response, self::CACHE_TTL);
        }

        return json_decode(wp_remote_retrieve_body($response), true);
    }

    public static function getForecastData($geolocationId, $accessToken)
    {
        // get forecast data
        $cacheKey = hash('sha256', $geolocationId);
        $response = get_transient('srf_weather_forecastpoint_' . $cacheKey);
        if (false === $response) {
            $response = wp_remote_get(
                self::API_BASE_URL . '/forecastpoint/' . $geolocationId,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                    'timeout' => self::REQUEST_TIMEOUT,
                ]
            );
            set_transient('srf_weather_forecastpoint_' . $cacheKey, $response, self::CACHE_TTL);
        }

        return wp_remote_retrieve_body($response);
    }

    public static function getNearestGeolocations($lat, $lon, $accessToken)
    {
        $cacheKey = hash('sha256', 'nearest_loc_'.$lat.$lon);
        $response = get_transient('srf_weather_nearestlocations' . $cacheKey);
       if (false === $response) {
            $response = wp_remote_get(
                $url = self::API_BASE_URL . sprintf('/geolocations?latitude=%s&longitude=%s&ch=1', $lat, $lon),
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                    'timeout' => self::REQUEST_TIMEOUT,
                ]
            );
            set_transient('srf_weather_nearestlocations' . $cacheKey, $response, self::CACHE_TTL);
        }

         return json_decode(wp_remote_retrieve_body($response), true);
    }
}
