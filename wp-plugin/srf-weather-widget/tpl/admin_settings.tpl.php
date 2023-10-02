<div id="srf-weather-widget-settings">
    <div class="wrap">
        <div class="wrap">
            <h2>SRF Weather Widget</h2>
            <p class="alert-info"><strong>Please note</strong> The Meteo API only returns data for locations in Switzerland.</p>
            <form method="post" action="options.php">
                <h3>API Auth</h3>
                <p>To get an SRF Meteo API Key <a href="https://developer.srgssr.ch/user/register">register here</a> and add the Meteo App <a href="https://developer.srgssr.ch/user/4205/create-app">here</a>. Use the "SRF-MeteoProductFreemium" Product to get a free account.
                </p>
                <?php
                settings_fields(SrfWeatherWidgetSettings::SRF_WEATHER_OPTION_GROUP);
                $apiKey = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY, 'api key');
                $apiSecret = get_option(SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET, 'api secret');
                ?>
                <label for="srf-weather-widget-auth-key";">API Key:</label>
                <input type="text" id="srf-weather-widget-auth-key" name="<?=SrfWeatherWidgetSettings::SRF_WEATHER_API_KEY; ?>" value="<?php echo esc_attr($apiKey); ?>" /><br />
                <label for="srf-weather-widget-auth-secret" style="">API Secret:</label>
                <input type="text" id="srf-weather-widget-auth-secret" name="<?=SrfWeatherWidgetSettings::SRF_WEATHER_API_SECRET; ?>" value="<?php echo esc_attr($apiSecret); ?>" />


                <?php submit_button(); ?>
            </form>
        </div>
    </div>
</div>




