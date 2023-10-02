import App from "./App.svelte";

document.querySelectorAll(".srf-weather-widget").forEach((element) => {
  new App({
    target: element,
    props: {
      size: element.dataset.size,
      mode: element.dataset.mode,
      geolocation: element.dataset.geolocation,
      locationName: element.dataset.locationName,
      forecastPoint: element.dataset.forecastPoint
        ? JSON.parse(element.dataset.forecastPoint)
        : null
    }
  });
});
