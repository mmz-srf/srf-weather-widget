const getGeolocationIdByLocationName = async (locationName) => {
  const response = await fetch(
    `https://www.srf.ch/meteoapi/geolocationNames?name=${locationName}`
  );
  if (response.ok) {
    const geolocationNames = await response.json();
    return geolocationNames[0].geolocation.id;
  }
};

const getGeolocationIdByCoordinates = async (longitude, latitude) => {
  const response = await fetch(
    `https://www.srf.ch/meteoapi//geolocations?longitude=${longitude}&latitude=${latitude}`
  );
  if (response.ok) {
    const geolocations = await response.json();
    return geolocations[0].id;
  }
};

const getPosition = async () => {
  if ("geolocation" in navigator) {
    return new Promise((resolve, reject) => {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          resolve(position);
        },
        (error) => {
          reject(error);
        }
      );
    });
  } else {
    throw Error();
  }
};

const getGeolocationId = async (geolocation, locationName) => {
  // default: Zürich Fernsehstudio
  let geolocationId = "47.4171,8.5612";
  if (geolocation) {
    geolocationId = geolocation;
  } else if (locationName) {
    if (locationName === "MyLocation") {
      const position = await getPosition();
      geolocationId = await getGeolocationIdByCoordinates(
        position.coords.longitude,
        position.coords.latitude
      );
    } else {
      geolocationId = await getGeolocationIdByLocationName(locationName);
    }
  }

  return geolocationId;
};

export const getForecastPoint = async (geolocation, locationName) => {
  try {
    let geolocationId = await getGeolocationId(geolocation, locationName);
    const response = await fetch(
      `https://www.srf.ch/meteoapi/forecastpoint/${geolocationId}`
    );
    if (response.ok) {
      return await response.json();
    }
  } catch (error) {
    console.error("Error fetching data:", error);
    throw error;
  }
};
