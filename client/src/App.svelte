<script>
  import TailwindCss from "./lib/TailwindCSS.svelte";

  async function getData() {
    const response = await fetch(
      "https://www.srf.ch/meteoapi/forecastpoint/47.3903,9.2775"
    );
    if (response.ok) {
      const data = await response.json();

      console.log(data);

      return data;
    }
  }
</script>

<TailwindCss />
<main>
  {#await getData() then data}
    <h2>{data.geolocation.default_name}</h2>
    <h3>{data.days[0].TN_C} | {data.days[0].TX_C}</h3>
  {/await}
</main>
