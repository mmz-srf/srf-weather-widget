<script>
  import WeatherIcons from "./WeatherIcons.svelte";

  export let weatherData;
  export let size;
</script>

<div
  class="flex flex-row items-center justify-between w-full max-w-sm text-white bg-blue-500 border-2 rounded-md border-cyan-900"
>
  <div class="flex flex-col my-4 ml-6 space-y-1">
    <h2 class="text-lg">{weatherData.geolocation.default_name}</h2>
    <h3 class="text-xl font-bold">
      {weatherData.days[0].TN_C}° | {weatherData.days[0].TX_C}°
    </h3>
  </div>
  <div class="my-4 mr-4">
    <WeatherIcons symbol={weatherData.days[0].symbol_code.toString()} />
  </div>
</div>
