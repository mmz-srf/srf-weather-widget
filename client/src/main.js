import App from "./App.svelte";
import TailwindCSS from "./lib/TailwindCSS.css?inline";

document.querySelectorAll(".srf-weather-widget").forEach((element) => {
  const shadowRoot = element.attachShadow({ mode: "open" });
  const shadowStyles = document.createElement("style");
  shadowStyles.innerHTML = TailwindCSS;
  shadowRoot.appendChild(shadowStyles);
  new App({
    target: shadowRoot,
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
