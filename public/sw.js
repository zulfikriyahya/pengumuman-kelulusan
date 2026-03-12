// public/sw.js
const CACHE_NAME = "presensi-rfid-v1";
const OFFLINE_URL = "/";

self.addEventListener("install", (event) => {
  self.skipWaiting(); // Langsung aktifkan SW baru
});

self.addEventListener("activate", (event) => {
  event.waitUntil(clients.claim()); // Ambil alih kontrol klien segera
});

self.addEventListener("fetch", (event) => {
  // Strategi: Network Only (Karena ini aplikasi realtime presensi)
  // Kita tidak ingin meng-cache request API presensi.
  // Jika offline, browser akan menangani fallback lewat manifest.
  event.respondWith(fetch(event.request));
});
