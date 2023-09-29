export async function fetchData() {
  try {
    const response = await fetch(
      "https://www.srf.ch/meteoapi/forecastpoint/47.3797,8.5342"
    );
    if (response.ok) {
      return await response.json();
    }
  } catch (error) {
    console.error("Error fetching data:", error);
    throw error;
  }
}
