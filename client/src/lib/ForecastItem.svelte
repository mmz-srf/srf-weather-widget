<script>
  import WeatherIcons from "./WeatherIcons.svelte";
  import RainBar from "./RainBar.svelte";

  export let value;
  export let symbol;
  export let dimensions;
  export let time;
  export let rainInMM;
  export let size;

  const isNow = ["Jetzt", "Heute"].includes(time);
  const fontWeight = isNow ? "font-bold" : "font-light";
</script>

<div class="flex flex-col items-center">
  <div class={`h-8 flex items-end ${fontWeight}`}>
    <span class="text-center">{time}</span>
  </div>
  <WeatherIcons {symbol} {dimensions} />
  <div class={`whitespace-nowrap ${size === "L" ? "mb-4" : ""}`}>{value}</div>
  {#if size === "L"}
    <RainBar {rainInMM} />
  {/if}
</div>
