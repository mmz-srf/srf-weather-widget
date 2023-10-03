<?php
class SrfWeatherWidgetSettings {
    const SRF_WEATHER_OPTION_GROUP = 'srf-weather-widget-auth';
    const SRF_WEATHER_API_KEY = 'srf-weather-api-key';
    const SRF_WEATHER_API_SECRET = 'srf-weather-api-secret-key';

    const DEFAULT_LOCATION = 'srf-weather-api-geolocation';
    const DEFAULT_LOCATION_NAME = 'srf-weather-api-geolocation-name';

    static $credentials = [];

    public function __construct()
    {
        add_action('admin_menu', array(__CLASS__, 'adminMenu'));
        add_action('admin_init', array(__CLASS__, 'initSettings'));
    }

    public static function validateGeolocation($value) {
        if (!$value) {
            return '';
        }

        if (!strpos($value, ',')) {
            add_settings_error(
                SrfWeatherWidgetSettings::DEFAULT_LOCATION,
                'wrong format',
                'swiss geolocation identifier must be in the format: xx.xxxx,x.xxxx (e.g. 47.5239,8.5363)'
            );

            return $value;
        }

        // Use the given keys to fetch the nearest point. Use the submitted options, not the
        // stored one for that (because a user can change them and it should work initially).
        $key = $_POST[SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY];
        $secret = $_POST[SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET];

        $token = SrfWeatherWidgetApiClient::getAccessToken($key, $secret);
        if (!$token) {

            return $value;
        }
        $parts = array_filter(explode(',', $value), 'trim');
        $nearest = SrfWeatherWidgetApiClient::getNearestGeolocations($parts[0], $parts[1], $token);
        if (!count($nearest)) {
            add_settings_error(
                SrfWeatherWidgetSettings::DEFAULT_LOCATION,
                'not ch',
                'geolocation must be in switzerland.'
            );

            return $value;
        } else {
            // update the geolocation name as well
            $_POST[SrfWeatherWidgetSettings::DEFAULT_LOCATION_NAME] = $nearest[0]['default_name']; // keep it simple
            return $nearest[0]['id'];
        }
    }

    public static function validateNonEmptyKey($value) {
        if (!$value) {
            add_settings_error(
                SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY,
                'not empty',
                'App Id must not be empty.'
            );

            return get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY);
;
        }
        self::$credentials['key'] = $value;

        return $value;
    }

    public static function validateConnection($value) {
        // not blank
        if (!$value) {
            add_settings_error(
                SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET,
                'not empty',
                'App Secret must not be empty.'
            );
            return get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET);
;
        }
        // no api key stored for some reason
        if (!isset(self::$credentials['key'])) {

            return get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET);
; // dont validate further
        }
        // validate connection (by retrieving an access token
        $accessToken = SrfWeatherWidgetApiClient::getAccessToken(self::$credentials['key'], $value);
        if (!$accessToken) {
            add_settings_error(
                SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET,
                'no connection',
                'Either API Key or API Secret is wrong.'
            );

            return get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET);
            ;
        }

        return self::$credentials['secret'] = $value;
    }



    public static function adminMenu() {
        add_menu_page(
            'SRF Weather',// page title
            'SRF Weather ☀️',// menu title
            'manage_options',// role
            'srf-weather-widget',// backend page identifier
            [__CLASS__, 'displayWeatherWidgetSettings'] // callback function
        );
    }

    public static function displayWeatherWidgetSettings() {
        include(__DIR__.'/tpl/admin_settings.tpl.php');
    }

    public static function initSettings() {
        register_setting(self::SRF_WEATHER_OPTION_GROUP, self::SRF_WEATHER_API_KEY, [SrfWeatherWidgetSettings::class, 'validateNonEmptyKey']);
        register_setting(self::SRF_WEATHER_OPTION_GROUP, self::SRF_WEATHER_API_SECRET, [SrfWeatherWidgetSettings::class, 'validateConnection']);
        register_setting(self::SRF_WEATHER_OPTION_GROUP, self::DEFAULT_LOCATION, [SrfWeatherWidgetSettings::class, 'validateGeolocation']);
        register_setting(self::SRF_WEATHER_OPTION_GROUP, self::DEFAULT_LOCATION_NAME);
    }
}

new SrfWeatherWidgetSettings();
