## SRF Weather Widget

Demo: https://mmz-srf.github.io/srf-weather-widget/

### Embed usage

```html
<!-- loads a weather widget at this exact position on the page -->
<div class="srf-weather-widget"></div>

<!-- loads the code that renders the weather widget -->
<script
  async
  type="module"
  src="https://mmz-srf.github.io/srf-weather-widget/main.js"
></script>
<link
  rel="stylesheet"
  href="https://mmz-srf.github.io/srf-weather-widget/main.css"
/>
```

### HTML Attributes

| Parameter     | Attribute           | Possible Values          | Default                               | Required |
| ------------- | ------------------- | ------------------------ | ------------------------------------- | -------- |
| Size          | data-size           | S, M, L                  | S                                     | No       |
| Mode          | data-mode           | hours, three_hours, days | hours                                 | No       |
| Geolocation   | data-geolocation    |                          | 47.4171,8.5612 (Zürich Fernsehstudio) | No       |
| Location Name | data-location-name  | Zürich, Genf, MyLocation |                                       | No       |
| ForecastPoint | data-forecast-point | <ForecastPointWeek>      |                                       | No       |
