import { defineConfig } from "vite";
import { svelte } from "@sveltejs/vite-plugin-svelte";
import { crx } from "@crxjs/vite-plugin";
import manifest from "./manifest.json";

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    rollupOptions: {
      input: ["index.html", "main.html"],
      output: {
        chunkFileNames: "[name].js",
        assetFileNames: (chunk) => {
          if (chunk.name.includes("css")) {
            return "[name].[ext]";
          } else {
            return "assets/[name]-[hash].[ext]";
          }
        },
      },
    },
  },
  plugins: [svelte(), crx({ manifest })],
  base: "./",
});
