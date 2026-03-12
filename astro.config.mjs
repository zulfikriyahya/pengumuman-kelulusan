// @ts-check
import { defineConfig } from "astro/config";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  vite: {
    plugins: [tailwindcss()],
    server: {
      proxy: {
        "/api": {
          target: "http://localhost:3000",
          changeOrigin: true,
          rewrite: (path) => {
            const rewritten = path.replace(/^\/api/, "") || "/";
            console.log(`[proxy] ${path} -> ${rewritten}`);
            return rewritten;
          },
        },
      },
    },
  },
});
