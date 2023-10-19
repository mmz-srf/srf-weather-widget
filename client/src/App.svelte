<script>
  import WeatherOverview from "./lib/WeatherOverview.svelte";
  import { getForecastPoint } from "./lib/utils";

  export let size = "S";
  export let mode = "hours";
  export let geolocation;
  export let locationName;
  export let forecastPoint;
</script>

<main
  class="flex justify-center mt-2"
  style={`
  line-height: 1.5; /* 1 */
  -webkit-text-size-adjust: 100%; /* 2 */
  -moz-tab-size: 4; /* 3 */
  -o-tab-size: 4;
     tab-size: 4; /* 3 */
  font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; /* 4 */
  font-feature-settings: normal; /* 5 */
  font-variation-settings: normal; /* 6 */`}
>
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
