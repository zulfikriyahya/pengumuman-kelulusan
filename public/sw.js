const VER = "skl-v3";
const STATIC = "skl-static-v3";
const DYNAMIC = "skl-dynamic-v3";
const OFFLINE = "/offline.html";

// Aset yang wajib tersedia offline
const PRECACHE = [
    "/",
    OFFLINE,
    "/favicon.ico",
    "/manifest.json",
    "/icons/icon-192.png",
    "/icons/icon-512.png",
];

// ── Install ─────────────────────────────────────────────────
self.addEventListener("install", (e) => {
    e.waitUntil(
        caches
            .open(STATIC)
            .then((c) => c.addAll(PRECACHE))
            .then(() => self.skipWaiting()),
    );
});

// ── Activate: bersihkan cache versi lama ────────────────────
self.addEventListener("activate", (e) => {
    const keep = [STATIC, DYNAMIC];
    e.waitUntil(
        caches
            .keys()
            .then((keys) =>
                Promise.all(
                    keys
                        .filter((k) => !keep.includes(k))
                        .map((k) => caches.delete(k)),
                ),
            )
            .then(() => self.clients.claim()),
    );
});

// ── Helpers ─────────────────────────────────────────────────
const isNavigate = (r) => r.mode === "navigate";
const isStatic = (url) =>
    /\.(css|js|woff2?|ttf|otf|svg|png|jpg|jpeg|webp|ico|gif)$/i.test(
        url.pathname,
    );
const isApi = (url) =>
    url.pathname.startsWith("/api") || url.pathname.startsWith("/sanctum");
const isAdmin = (url) => url.pathname.startsWith("/admin");
const isCacheable = (res) =>
    res && res.status === 200 && ["basic", "cors"].includes(res.type);

// ── Fetch ────────────────────────────────────────────────────
self.addEventListener("fetch", (e) => {
    const url = new URL(e.request.url);

    // Lewati: non-GET, admin, API, cross-origin non-static
    if (e.request.method !== "GET") return;
    if (isAdmin(url) || isApi(url)) return;

    // Aset statis → Cache First
    if (isStatic(url)) {
        e.respondWith(
            caches.match(e.request).then((cached) => {
                if (cached) return cached;
                return fetch(e.request).then((res) => {
                    if (isCacheable(res)) {
                        caches
                            .open(STATIC)
                            .then((c) => c.put(e.request, res.clone()));
                    }
                    return res;
                });
            }),
        );
        return;
    }

    // Halaman navigasi & request lain → Network First + fallback offline
    e.respondWith(
        fetch(e.request)
            .then((res) => {
                if (isCacheable(res) && isNavigate(e.request)) {
                    caches
                        .open(DYNAMIC)
                        .then((c) => c.put(e.request, res.clone()));
                }
                return res;
            })
            .catch(() =>
                caches.match(e.request).then((cached) => {
                    if (cached) return cached;
                    if (isNavigate(e.request)) return caches.match(OFFLINE);
                }),
            ),
    );
});

// ── Background Sync placeholder (opsional, future use) ──────
self.addEventListener("message", (e) => {
    if (e.data?.type === "SKIP_WAITING") self.skipWaiting();
});
