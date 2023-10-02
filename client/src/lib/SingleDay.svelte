<script>
  import WeatherIcons from "./WeatherIcons.svelte";

  export let dailyTemp;
  export let symbol;
  export let dimensions;
  export let currentTime;
  export let rainInMM;
  export let size;

  const isNow = currentTime === "Jetzt";
  const fontWeight = isNow ? "font-bold" : "font-light";
</script>

<div class="flex flex-col items-center">
  <div class={fontWeight}>{currentTime}</div>
  <WeatherIcons {symbol} {dimensions} />
  <div>{dailyTemp}°</div>
  {#if size === "L"}
    <div>{rainInMM}</div>
  {/if}
</div>
