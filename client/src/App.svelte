<script>
  import { onMount } from "svelte";
  import TailwindCss from "./lib/TailwindCSS.svelte";
  import WeatherOverview from "./lib/WeatherOverview.svelte";
  export let size;
  let weatherData = null;

  async function fetchData() {
    try {
      const response = await fetch(
        "https://www.srf.ch/meteoapi/forecastpoint/47.3797,8.5342"
      );
      if (response.ok) {
        const data = await response.json();
        weatherData = data;
      }
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }
  onMount(() => {
    fetchData();
  });
</script>

<TailwindCss />
<main class="flex justify-center mt-2">
  {#if weatherData}
    <WeatherOverview {weatherData} {size} />
  {:else}
    <p>Loading...</p>
  {/if}
</main>
