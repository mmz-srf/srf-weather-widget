<?php
$apiKey = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY, 'api key');
$apiSecret = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET, 'api secret');
$location = get_option(SrfWeatherWidgetSettings::DEFAULT_LOCATION, '');
$locationName = get_option(SrfWeatherWidgetSettings::DEFAULT_LOCATION_NAME);
$errors = $errors = get_settings_errors();
$errorFields = [];
// lookup map
foreach($errors as $errorField) {
    $errorFields[$errorField['setting']] = $errorField['message'];
}

?>
<div id="srf-weather-widget-settings">
    <div class="wrap">
        <div class="wrap">
            <h2>SRF Weather Widget</h2>
            <form method="post" action="options.php">
                <?php settings_fields(SrfWeatherWidgetSettings::SRF_WEATHER_OPTION_GROUP); ?>
                <h3>API Auth</h3>
                <p>To get an SRF Meteo API Key <a href="https://developer.srgssr.ch/user/register">register here</a> and add the Meteo App <a href="https://developer.srgssr.ch/user/4205/create-app">here</a>. Use the "SRF-MeteoProductFreemium" Product to get a free account.
                </p>
                <p class="alert-info">Note: The Meteo API only returns data for places in Switzerland.</p>
                <?php if ($errors) { ?>
                    <ul class="error">
                    <?php foreach ($errors as $e) { ?>
                        <li><?=$e['message'];?></li>
                    <?php } ?>
                    </ul>
                <?php } ?>

                <label for="srf-weather-widget-auth-key">App Id:</label>
                <input type="text" id="srf-weather-widget-auth-key" name="<?=SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY; ?>" value="<?php echo esc_attr($apiKey); ?>" /><br />
                <label for="srf-weather-widget-auth-secret">App Secret:</label>
                <input type="text" id="<?=SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET; ?>" name="<?=SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET; ?>" value="<?php echo esc_attr($apiSecret); ?>" />
                <h3>Default location</h3>
                <p>Set either a defalut location by its location id (most accurate results, but the api must be used to find out a correct location). Or just use the name of the city.</p>
                <label for="<?=SrfWeatherWidgetSettings::DEFAULT_LOCATION; ?>">Default Location (lat.lon):</label>
                <input type="text" id="<?=SrfWeatherWidgetSettings::DEFAULT_LOCATION; ?>" name="<?=SrfWeatherWidgetSettings::DEFAULT_LOCATION; ?>" value="<?php echo esc_attr($location); ?>" />
                <span class="error-field"><?= ($errorFields[SrfWeatherWidgetSettings::DEFAULT_LOCATION] ?? ''); ?></span>
                <label for=<?=SrfWeatherWidgetSettings::DEFAULT_LOCATION_NAME; ?>>Default location name (if no location is given, search by name)</label>
                <input type="text" id="<?=SrfWeatherWidgetSettings::DEFAULT_LOCATION_NAME; ?>" name="<?=SrfWeatherWidgetSettings::DEFAULT_LOCATION_NAME;?>" value="<?php echo esc_attr($locationName); ?>" />
                <?php submit_button(); ?>
            </form>
        </div>
    </div>
</div>

<?php




