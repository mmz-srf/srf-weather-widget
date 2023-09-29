import App from "./App.svelte";

document.querySelectorAll(".srf-weather-widget").forEach((element) => {
  new App({
    target: element
  });
});
