<?php

class SrfWeatherWidgetInstallation
{
    public function __construct()
    {
        // Hook, um Standardwerte beim Aktivieren des Plugins zu setzen
        // set defaults after activation
        register_activation_hook(__FILE__, array(__CLASS__, 'activate'));
        // remove stuff after deactivation plugin
        register_deactivation_hook(__FILE__, array(__CLASS__, 'deactivate'));
        // cleanup settings after removal
        register_uninstall_hook(__FILE__, array(__CLASS__, 'uninstall'));
    }

    public static function activate() {
    }

    public static function deactivate() {
    }

    public static function uninstall() {
        delete_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY);
        delete_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET);
    }
}