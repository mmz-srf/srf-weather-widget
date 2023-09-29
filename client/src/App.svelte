<script>
  import TailwindCss from "./lib/TailwindCSS.svelte";
  import WeatherOverview from "./lib/WeatherOverview.svelte";
  import { fetchData } from "./lib/utils";

  export let size;
  export let geolocation;
  export let locationName;
</script>

<TailwindCss />
<main class="flex justify-center mt-2">
  {#await fetchData(geolocation, locationName)}
    <p>Loading...</p>
  {:then weatherData}
    <WeatherOverview {weatherData} {size} />
  {:catch}
    <p>Error fetching data</p>
  {/await}
</main>
