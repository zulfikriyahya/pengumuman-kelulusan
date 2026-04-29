const CACHE = "skl-v1";
const OFFLINE = "/offline.html";

// Aset statis yang di-precache saat install
const PRECACHE = ["/", OFFLINE, "/favicon.ico", "/manifest.json"];

// ── Install: precache aset ──────────────────────────────────
self.addEventListener("install", (e) => {
    e.waitUntil(
        caches
            .open(CACHE)
            .then((c) => c.addAll(PRECACHE))
            .then(() => self.skipWaiting()),
    );
});

// ── Activate: hapus cache lama ──────────────────────────────
self.addEventListener("activate", (e) => {
    e.waitUntil(
        caches
            .keys()
            .then((keys) =>
                Promise.all(
                    keys
                        .filter((k) => k !== CACHE)
                        .map((k) => caches.delete(k)),
                ),
            )
            .then(() => self.clients.claim()),
    );
});

// ── Fetch: Network-first, fallback cache, fallback offline ──
self.addEventListener("fetch", (e) => {
    // Lewati request non-GET dan request ke API/admin
    const url = new URL(e.request.url);
    if (e.request.method !== "GET") return;
    if (url.pathname.startsWith("/admin")) return;
    if (url.pathname.startsWith("/api")) return;

    e.respondWith(
        fetch(e.request)
            .then((res) => {
                // Simpan salinan response ke cache (hanya response valid)
                if (res && res.status === 200 && res.type === "basic") {
                    const clone = res.clone();
                    caches.open(CACHE).then((c) => c.put(e.request, clone));
                }
                return res;
            })
            .catch(() =>
                caches.match(e.request).then((cached) => {
                    if (cached) return cached;
                    // Jika halaman HTML tidak ada di cache → halaman offline
                    if (
                        e.request.headers.get("accept")?.includes("text/html")
                    ) {
                        return caches.match(OFFLINE);
                    }
                }),
            ),
    );
});
