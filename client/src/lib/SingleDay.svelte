<script>
  import WeatherIcons from "./WeatherIcons.svelte";

  export let dailyTemp;
  export let symbol;
  export let dimensions;
  export let currentTime;
  export let rainInMM;
  export let size;

  rainInMM = 8;

  const isNow = currentTime === "Jetzt";
  const fontWeight = isNow ? "font-bold" : "font-light";
</script>

<div class="flex flex-col items-center">
  <div class={fontWeight}>{currentTime}</div>
  <WeatherIcons {symbol} {dimensions} />
  <div class="mb-4">{dailyTemp}°</div>
  {#if size === "L"}
    <div class="h-8 w-full flex flex-col-reverse items-center">
      <div
        class="bg-sky-500 w-1/2 max-h-8 relative flex flex-col items-center"
        style={`height: ${rainInMM * 2.5}px;`}
      >
        <span class="absolute font-light">{rainInMM}</span>
      </div>
    </div>
  {/if}
</div>
