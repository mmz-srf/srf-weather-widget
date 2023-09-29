<script>
  import WeatherIcons from "./WeatherIcons.svelte";

  export let weatherData;
  export let size;
</script>

<div
  class="flex flex-row items-center justify-between w-full max-w-sm text-white shadow-lg shadow-gray-4ow 00 rounded-xl bg-widget-dark"
>
  <div class="flex flex-col my-4 ml-6 space-y-1">
    <h2 class="text-sm">{weatherData.geolocation.default_name}</h2>
    <h3
      class="flex flex-row items-center justify-center space-x-2 text-base font-light"
    >
      <div>{weatherData.days[0].TN_C}°</div>
      <div>|</div>
      <div class="font-bold">{weatherData.days[0].TX_C}°</div>
    </h3>
  </div>
  <div class="my-4 mr-4">
    <WeatherIcons symbol={weatherData.days[0].symbol_code.toString()} />
  </div>
</div>
