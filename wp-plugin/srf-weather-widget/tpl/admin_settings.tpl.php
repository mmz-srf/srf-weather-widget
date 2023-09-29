<div class="wrap">
    <div class="wrap">
        <h2>SRF Weather Widget</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields(SrfWeatherWidgetSettings::SRF_WEATHER_OPTION_GROUP);
            $apiKey = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY, 'api key');
            $apiSecret = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET, 'api secret');
            ?>
            <label for="srf-weather-widget-auth-key" style="display:block;">API Key:</label>
            <input type="text" id="srf-weather-widget-auth-key" name="<?=SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY; ?>" value="<?php echo esc_attr($apiKey); ?>" /><br />
            <label for="srf-weather-widget-auth-secret" style="display:block;">API Secret:</label>
            <input type="text" id="srf-weather-widget-auth-secret" name="<?=SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET; ?>" value="<?php echo esc_attr($apiSecret); ?>" />
            <?php submit_button(); ?>
        </form>
    </div>
</div>



