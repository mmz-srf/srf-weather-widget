const getGeolocationIdByLocationName = async (locationName) => {
  const response = await fetch(
    `https://www.srf.ch/meteoapi/geolocationNames?name=${locationName}`
  );
  if (response.ok) {
    const geolocationNames = await response.json();
    return geolocationNames[0].geolocation.id;
  }
};

const getGeolocationId = async (geolocation, locationName) => {
  // default: Zürich Fernsehstudio
  let geolocationId = "47.4171,8.5612";
  if (geolocation) {
    geolocationId = geolocation;
  } else if (locationName) {
    geolocationId = await getGeolocationIdByLocationName(locationName);
  }

  return geolocationId;
};

export const fetchData = async (geolocation, locationName) => {
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
