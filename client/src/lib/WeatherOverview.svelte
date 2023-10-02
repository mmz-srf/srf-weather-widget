<script>
  import SingleDay from "./SingleDay.svelte";
  import WeatherIcons from "./WeatherIcons.svelte";

  export let weatherData;
  export let size;
  let currentIndex = -1;

  const currentDate = new Date();

  for (let i = 0; i < weatherData.hours.length; i++) {
    const date_time = new Date(weatherData.hours[i].date_time);
    if (date_time >= currentDate) {
      currentIndex = i;
      break;
    }
  }
</script>

<div
  class="flex flex-col w-full max-w-sm tracking-widest text-white shadow-lg shadow-gray-400 rounded-xl bg-widget-dark"
>
  <div
    class="flex flex-row items-center justify-between w-full max-w-sm tracking-widest text-white rounded-xl bg-widget-dark"
  >
    <div class="flex flex-col my-4 ml-6 space-y-1">
      <h2 class="text-sm">{weatherData.geolocation.default_name}</h2>
      <h3 class="flex flex-row space-x-2 text-base font-light">
        <div>{weatherData.days[0].TN_C}°</div>
        <div>|</div>
        <div class="font-bold">{weatherData.days[0].TX_C}°</div>
      </h3>
    </div>
    <div class="my-4 mr-4">
      <WeatherIcons
        symbol={weatherData.days[0].symbol_code.toString()}
        dimensions="w-14 h-14"
      />
    </div>
  </div>
  {#if ["L", "M"].includes(size.toUpperCase())}
    <div
      class="flex flex-row ml-6 space-x-6 overflow-scroll text-xs font-bold scrollbar-hide"
    >
      {#each weatherData.hours as hours, index}
        {#if index >= currentIndex}
          <SingleDay
            currentTime={index === currentIndex
              ? "Jetzt"
              : new Date(hours.date_time).toLocaleTimeString([], {
                  hour: "2-digit",
                  minute: "2-digit",
                })}
            symbol={hours.symbol_code}
            dimensions="w-6 h-6"
            dailyTemp={hours.TTT_C}
            rainInMM={hours.RRR_MM}
            {size}
          />
        {/if}
      {/each}
    </div>
  {/if}
</div>

<style>
  /* For Webkit-based browsers (Chrome, Safari and Opera) */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }

  /* For IE, Edge and Firefox */
  .scrollbar-hide {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
</style>
