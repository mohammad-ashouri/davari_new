// vite.config.js
import { defineConfig } from "file:///D:/Laravel_Projects/davari_new/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/Laravel_Projects/davari_new/node_modules/laravel-vite-plugin/dist/index.mjs";
import vue from "file:///D:/Laravel_Projects/davari_new/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import tailwindcss from "file:///D:/Laravel_Projects/davari_new/node_modules/tailwindcss/lib/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/login.css", "resources/js/login.js", "resources/css/app.css", "resources/js/app.js"],
      refresh: true
    }),
    vue()
  ],
  css: {
    postcss: {
      plugins: [
        tailwindcss("./tailwind.config.js")
      ]
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxMYXJhdmVsX1Byb2plY3RzXFxcXGRhdmFyaV9uZXdcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkQ6XFxcXExhcmF2ZWxfUHJvamVjdHNcXFxcZGF2YXJpX25ld1xcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vRDovTGFyYXZlbF9Qcm9qZWN0cy9kYXZhcmlfbmV3L3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB2dWUgZnJvbSAnQHZpdGVqcy9wbHVnaW4tdnVlJztcbmltcG9ydCB0YWlsd2luZGNzcyBmcm9tICd0YWlsd2luZGNzcyc7XG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogWydyZXNvdXJjZXMvY3NzL2xvZ2luLmNzcycsJ3Jlc291cmNlcy9qcy9sb2dpbi5qcycsJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsICdyZXNvdXJjZXMvanMvYXBwLmpzJ10sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICAgICAgdnVlKCksXG4gICAgXSxcbiAgICBjc3M6IHtcbiAgICAgICAgcG9zdGNzczoge1xuICAgICAgICAgICAgcGx1Z2luczogW1xuICAgICAgICAgICAgICAgIHRhaWx3aW5kY3NzKCcuL3RhaWx3aW5kLmNvbmZpZy5qcycpLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgfSxcbiAgICB9LFxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQWtSLFNBQVMsb0JBQW9CO0FBQy9TLE9BQU8sYUFBYTtBQUNwQixPQUFPLFNBQVM7QUFDaEIsT0FBTyxpQkFBaUI7QUFDeEIsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTyxDQUFDLDJCQUEwQix5QkFBd0IseUJBQXlCLHFCQUFxQjtBQUFBLE1BQ3hHLFNBQVM7QUFBQSxJQUNiLENBQUM7QUFBQSxJQUNELElBQUk7QUFBQSxFQUNSO0FBQUEsRUFDQSxLQUFLO0FBQUEsSUFDRCxTQUFTO0FBQUEsTUFDTCxTQUFTO0FBQUEsUUFDTCxZQUFZLHNCQUFzQjtBQUFBLE1BQ3RDO0FBQUEsSUFDSjtBQUFBLEVBQ0o7QUFDSixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
