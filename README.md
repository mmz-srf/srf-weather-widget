## SRF Weather Widget

Demo: https://mmz-srf.github.io/srf-weather-widget/

### Embed usage

```html
<!-- loads a weather widget at this exact position on the page -->
<div class="srf-weather-widget"></div>

<!-- loads the code that renders the weather widget -->
<script
  type="module"
  src="https://mmz-srf.github.io/srf-weather-widget/index.js"
></script>
<link
  rel="stylesheet"
  href="https://mmz-srf.github.io/srf-weather-widget/index.css"
/>
```

### HTML Attributes

| Parameter     | Attribute          | Possible Values | Default                               | Required |
| ------------- | ------------------ | --------------- | ------------------------------------- | -------- |
| Size          | data-size          | S, M, L         | S                                     | No       |
| Geolocation   | data-geolocation   |                 | 47.4171,8.5612 (Zürich Fernsehstudio) | No       |
| Location Name | data-location-name | Zürich, Genf    |                                       | No       |
