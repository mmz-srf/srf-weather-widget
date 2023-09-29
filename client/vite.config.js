import { defineConfig } from "vite";
import { svelte } from "@sveltejs/vite-plugin-svelte";

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    rollupOptions: {
      output: {
        entryFileNames: "[name].js",
        assetFileNames: (chunk) => {
          if (chunk.name.includes("css")) {
            return "[name].[ext]";
          } else {
            return "assets/[name]-[hash].[ext]";
          }
        }
      }
    }
  },
  plugins: [svelte()],
  base: "./"
});
