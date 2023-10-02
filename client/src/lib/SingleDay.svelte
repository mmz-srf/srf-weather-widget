<script>
  import WeatherIcons from "./WeatherIcons.svelte";
  import RainBar from "./RainBar.svelte";

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
  <div class={size === "L" && "mb-4"}>{dailyTemp}°</div>
  {#if size === "L"}
    <RainBar {rainInMM} />
  {/if}
</div>
