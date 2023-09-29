<?php

class SrfWeatherWidgetSettings {
    const SRF_WEATHER_API_KEY = 'srf_weather_api_key';
    const SRF_WEATHER_API_SECRET = 'srf_weather_api_secret_key';

    public function __construct()
    {
        // Hook, um Standardwerte beim Aktivieren des Plugins zu setzen
    }
    public static function init() {
        // set defaults after activation
        register_activation_hook(__FILE__, array(self, 'activate_plugin'));
        // remove stuff after deactivation plugin
        register_deactivation_hook(__FILE__, array(self, 'deactivate_plugin'));
        // cleanup settings after removal
        register_uninstall_hook(__FILE__, array(self, 'uninstall_plugin'));
    }

    public static function activate_plugin() {
        // Standardwert für den Hello World-Text setzen
        $default_text = 'World';
        update_option(self::SRF_WEATHER_API_KEY, 'api-key');
        update_option(self::SRF_WEATHER_API_SECRET, 'api-secret');

    }

    public static function deactivate_plugin() {
        // nothing to do for now
    }

    public static function uninstall_plugin() {
        delete_option(self::SRF_WEATHER_API_KEY);
        delete_option(self::SRF_WEATHER_API_SECRET);

    }
}