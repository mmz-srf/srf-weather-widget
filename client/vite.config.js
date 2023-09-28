import { defineConfig } from "vite";
import { svelte } from "@sveltejs/vite-plugin-svelte";

const assetBase = process.env.VITE_ASSET_BASE || "./";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [svelte()],
  build: {
    assetsDir: assetBase
  }
});
