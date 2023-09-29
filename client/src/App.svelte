<script>
  import { onMount } from "svelte";
  import TailwindCss from "./lib/TailwindCSS.svelte";
  import WeatherIcons from "./lib/WeatherIcons.svelte";

  export let size;
  export let geolocation;
  export let locationName;

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
<main class="flex justify-center">
  {#if weatherData}
    <div
      class="flex flex-row items-center justify-between w-full max-w-sm text-white bg-blue-500 border-2 rounded-md border-cyan-900"
    >
      <div class="flex flex-col my-4 ml-6 space-y-1">
        <h2 class="text-lg">{weatherData.geolocation.default_name}</h2>
        <h3 class="text-xl font-bold">
          {weatherData.days[0].TN_C} | {weatherData.days[0].TX_C}
        </h3>
      </div>
      <div class="my-4 mr-4">
        <WeatherIcons symbol={weatherData.days[0].symbol_code.toString()} />
      </div>
    </div>
  {:else}
    <p>Loading...</p>
  {/if}
</main>
