## Wordpress Plugin for SRF Weather Widget

### Installation

tbd

### Shortcode usage

The following shortcode can be added to a post's content or in the theme of your blog at your prefered position (e.g. sidebar). Just click on the Plus-Button, choose "shortcode" and enter the widget's shortcode like below.  

Most simple variant. Uses position set in wordpress settings, size s, displays next hours:
```html
[meteo]
```

Same as above, but set a specific size:
```html
[meteo size="L"]
```

Medium size and with days instead of hours:
```html
[meteo size="M" mode="days"]
```

Small widget with Bern as position:
```html
[meteo geolocation="46.9471,7.4441"]
```

Or use Bern as position by its name:
```html
[meteo locationName="Bern"]
```

### Shortcode Attributes

| Name          | Attribute           | Possible Values          | Default                               | Required |
|---------------|---------------------| ------------------------ | ------------------------------------- | -------- |
| Size          | size                | S, M, L                  | S                                     | No       |
| Mode          | mode                | hours, three_hours, days | hours                                 | No       |
| Geolocation   | geolocation         |                          | 47.4171,8.5612 (Zürich Fernsehstudio) | No       |
| Location Name | locationName        | Zürich, Genf, MyLocation |                                       | No       |
