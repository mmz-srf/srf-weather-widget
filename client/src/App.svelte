<script>
  import TailwindCss from "./lib/TailwindCSS.svelte";
  import WeatherOverview from "./lib/WeatherOverview.svelte";
  import { getForecastPoint } from "./lib/utils";

  export let size;
  export let geolocation;
  export let locationName;
  export let forecastPoint;
</script>

<TailwindCss />
<main class="flex justify-center mt-2">
  {#if forecastPoint}
    <WeatherOverview weatherData={forecastPoint} {size} />
  {:else}
    {#await getForecastPoint(geolocation, locationName)}
      <p>Loading...</p>
    {:then weatherData}
      <WeatherOverview {weatherData} {size} />
    {:catch}
      <p>Error fetching data</p>
    {/await}
  {/if}
</main>
