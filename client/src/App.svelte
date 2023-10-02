<script>
  import TailwindCss from "./lib/TailwindCSS.svelte";
  import WeatherOverview from "./lib/WeatherOverview.svelte";
  import { getForecastPoint } from "./lib/utils";

  export let size = "S";
  export let mode = "hours";
  export let geolocation;
  export let locationName;
  export let forecastPoint;
</script>

<TailwindCss />
<main class="flex justify-center mt-2">
  {#if forecastPoint}
    <WeatherOverview
      {forecastPoint}
      size={size.toUpperCase()}
      mode={mode.toLowerCase()}
    />
  {:else}
    {#await getForecastPoint(geolocation, locationName)}
      <p>Loading...</p>
    {:then forecastPoint}
      <WeatherOverview
        {forecastPoint}
        size={size.toUpperCase()}
        mode={mode.toLowerCase()}
      />
    {:catch}
      <p>Error fetching data</p>
    {/await}
  {/if}
</main>
