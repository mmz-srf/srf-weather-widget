<script>
  import ForecastItem from "./ForecastItem.svelte";
  import WeatherIcons from "./WeatherIcons.svelte";

  export let forecastPoint;
  export let size;
  export let mode;

  const forecastItems = forecastPoint[mode].filter((item) => {
    const currentDate = new Date();

    if (mode === "days") {
      currentDate.setHours(0, 0, 0, 0);
    }
    return new Date(item.date_time).getTime() >= currentDate.getTime();
  });

  const getTime = (item, index, mode) => {
    let time = new Date(item.date_time).toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit"
    });

    if (index === 0) {
      time = mode === "days" ? "Heute" : "Jetzt";
    } else if (mode === "days") {
      time = new Date(item.date_time)
        .toLocaleTimeString([], {
          weekday: "long"
        })
        .replace(/, \d+:\d+:\d+/, "");
    }

    return time;
  };

  const getValue = (item, mode) => {
    let value = `${item.TTT_C}°`;
    if (mode === "days") {
      value = `${item.TN_C}° | ${item.TX_C}°`;
    }

    return value;
  };
</script>

<div
  class="flex flex-col w-full max-w-sm tracking-widest text-white shadow-lg shadow-gray-400 rounded-xl bg-widget-dark"
>
  <div
    class="flex flex-row items-center justify-between w-full max-w-sm tracking-widest text-white rounded-xl bg-widget-dark"
  >
    <div class="flex flex-col my-4 ml-6 space-y-1">
      <h2 class="text-sm">
        <a
          href={`https://www.srf.ch/meteo/wetter/${forecastPoint.geolocation.default_name}/${forecastPoint.geolocation.id}`}
        >
          {forecastPoint.geolocation.default_name}
        </a>
      </h2>
      <h3 class="flex flex-row space-x-2 text-base font-light">
        <div>{forecastPoint.days[0].TN_C}°</div>
        <div>|</div>
        <div class="font-bold">{forecastPoint.days[0].TX_C}°</div>
      </h3>
    </div>
    <div class="my-4 mr-4">
      <WeatherIcons
        symbol={forecastPoint.days[0].symbol_code.toString()}
        dimensions="w-14 h-14"
      />
    </div>
  </div>
  {#if ["L", "M"].includes(size.toUpperCase())}
    <div
      class="flex flex-row mb-2 ml-6 mr-1 space-x-6 overflow-scroll text-xs font-bold scrollbar-hide scroll-shadow"
    >
      {#each forecastItems as item, index}
        <ForecastItem
          time={getTime(item, index, mode)}
          symbol={item.symbol_code}
          dimensions="w-6 h-6"
          value={getValue(item, mode)}
          rainInMM={item.RRR_MM}
          {size}
        />
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

  .scroll-shadow {
    background-image: linear-gradient(
        to right,
        rgba(8, 81, 139, 1),
        rgba(8, 81, 139, 1)
      ),
      linear-gradient(to right, rgba(8, 81, 139, 1), rgba(8, 81, 139, 1)),
      linear-gradient(to right, rgba(0, 0, 0, 0.25), rgba(255, 255, 255, 0)),
      linear-gradient(to left, rgba(0, 0, 0, 0.25), rgba(255, 255, 255, 0));
    background-position: left center, right center, left center, right center;
    background-repeat: no-repeat;
    background-size: 20px 100%, 20px 100%, 10px 100%, 10px 100%;
    background-attachment: local, local, scroll, scroll;
  }
</style>
