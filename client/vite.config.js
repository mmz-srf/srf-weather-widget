import { defineConfig } from "vite";
import { svelte } from "@sveltejs/vite-plugin-svelte";
import { createHtmlPlugin } from "vite-plugin-html";
import webExtension from "vite-plugin-web-extension";

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
        },
      },
    },
  },
  plugins: [
    createHtmlPlugin({
      minify: true,
      pages: [
        {
          entry: "src/main.js",
          filename: "index.html",
          template: "index.html",
        },
        {
          entry: "src/main.js",
          filename: "main.html",
          template: "main.html",
        },
      ],
    }),
    svelte(),
    webExtension(),
  ],
  base: "./",
});
