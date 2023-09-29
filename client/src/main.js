import App from "./App.svelte";

document.querySelectorAll(".srf-weather-widget").forEach((element) => {
  new App({
    target: element,
    props: {
      size: element.dataset.size,
      geolocation: element.dataset.geolocation,
      locationName: element.dataset.locationName
    }
  });
});
