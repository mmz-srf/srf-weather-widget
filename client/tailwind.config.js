export default {
  plugins: [],
  theme: {
    extend: {
      colors: {
        widget: {
          dark: "#08518B",
          light: "#0A67B0",
        },
      },
    },
  },
  purge: ["./index.html", "./src/**/*.{svelte,js,ts}"], //for unused css
  variants: {
    extend: {},
  },
  darkmode: false, // or 'media' or 'class'
};
