<?php

class SrfWeatherWidgetSettings {
    const SRF_WEATHER_OPTION_GROUP = 'srf-weather-widget-auth';
    const SRF_WEATHER_API_KEY = 'srf-weather-api-key';
    const SRF_WEATHER_API_SECRET = 'srf-weather-api-secret-key';

    const DEFAULT_LOCATION = 'srf-weather-api-geolocation';
    const DEFAULT_LOCATION_NAME = 'srf-weather-api-geolocation-name';

    public function __construct()
    {
        add_action('admin_menu', array(__CLASS__, 'adminMenu'));
        add_action('admin_init', array(__CLASS__, 'initSettings'));
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
        register_setting(self::SRF_WEATHER_OPTION_GROUP, self::SRF_WEATHER_API_KEY);
        register_setting(self::SRF_WEATHER_OPTION_GROUP, self::SRF_WEATHER_API_SECRET);
        //register_setting(self::SRF_WEATHER_OPTION_GROUP, self::DEFAULT_LOCATION);
        //register_setting(self::SRF_WEATHER_OPTION_GROUP, self::DEFAULT_LOCATION_NAME);
    }
}