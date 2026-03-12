# Project Files

.
├── astro.config.mjs
├── Kode.gs
├── package.json
├── public
│   ├── favicon.svg
│   ├── icons
│   │   ├── 192x192.png
│   │   └── 512x512.png
│   ├── manifest.json
│   └── sw.js
├── src
│   ├── layouts
│   │   └── Layout.astro
│   ├── pages
│   │   └── index.astro
│   └── styles
│       └── global.css
└── tsconfig.json

7 directories, 12 files

# File Contents

## ./astro.config.mjs

```javascript
// @ts-check
import { defineConfig } from "astro/config";
import tailwindcss from "@tailwindcss/vite";

// https://astro.build/config
export default defineConfig({
  vite: {
    plugins: [tailwindcss()],
  },
});

```
---

## ./package.json

```json
{
  "name": "presensi-rfid-astro",
  "type": "module",
  "version": "1.0.0",
  "scripts": {
    "dev": "astro dev",
    "build": "astro build",
    "preview": "astro preview",
    "astro": "astro"
  },
  "dependencies": {
    "@tailwindcss/vite": "^4.0.0",
    "astro": "^5.0.0",
    "tailwindcss": "^4.0.0"
  }
}

```
---

## ./Kode.gs

```javascript
/**
 * KONFIGURASI UMUM
 */
const SS_ID = SpreadsheetApp.getActiveSpreadsheet().getId();
const SHEET_PENGGUNA = "PENGGUNA";
const SHEET_PENGATURAN = "PENGATURAN";
const NAMA_BULAN = [
  "JAN",
  "FEB",
  "MAR",
  "APR",
  "MEI",
  "JUN",
  "JUL",
  "AGU",
  "SEP",
  "OKT",
  "NOV",
  "DES",
];

const ACTIVITY_OFFSET = {
  Datang: 0,
  Pulang: 1,
  Isya: 2,
  Subuh: 3,
  Dzuhur: 4,
  Ashar: 5,
  Maghrib: 6,
  Tahajjud: 7,
  Dhuha: 8,
};

/**
 * 1. GET: Return Config JSON untuk Astro
 */
function doGet(e) {
  const ss = SpreadsheetApp.openById(SS_ID);
  const config = getConfig(ss);

  // Return JSON, bukan HTML
  return ContentService.createTextOutput(
    JSON.stringify({
      status: "success",
      data: config,
    })
  ).setMimeType(ContentService.MimeType.JSON);
}

/**
 * 2. POST: Handle Input
 */
function doPost(e) {
  const lock = LockService.getScriptLock();
  try {
    lock.waitLock(10000);

    let rfid = "";
    let mode = "SHOLAT";

    // Handle JSON Payload dari fetch() Astro
    if (e.postData && e.postData.contents) {
      const data = JSON.parse(e.postData.contents);
      rfid = data.rfid;
      if (data.mode) mode = data.mode;
    } else {
      rfid = e.parameter.rfid;
      if (e.parameter.mode) mode = e.parameter.mode;
    }

    if (!rfid) throw new Error("RFID Kosong");

    const result = processTapping(rfid, mode);

    return ContentService.createTextOutput(
      JSON.stringify({
        status: "success",
        data: result,
      })
    ).setMimeType(ContentService.MimeType.JSON);
  } catch (error) {
    return ContentService.createTextOutput(
      JSON.stringify({
        status: "error",
        message: error.message,
      })
    ).setMimeType(ContentService.MimeType.JSON);
  } finally {
    lock.releaseLock();
  }
}

// ... (Fungsi processTapping, getConfig, isTimeInRange SAMA PERSIS seperti sebelumnya) ...
// Copy paste fungsi logika dari jawaban sebelumnya di sini
function processTapping(rfid, mode) {
  const cache = CacheService.getScriptCache();
  const cacheKey = "USER_" + String(rfid).trim();
  let namaLengkap = cache.get(cacheKey);

  const ss = SpreadsheetApp.openById(SS_ID);

  if (!namaLengkap) {
    const sheetPengguna = ss.getSheetByName(SHEET_PENGGUNA);
    const dataPengguna = sheetPengguna.getDataRange().getValues();

    for (let i = 1; i < dataPengguna.length; i++) {
      if (String(dataPengguna[i][1]).trim() === String(rfid).trim()) {
        if (String(dataPengguna[i][8]).toUpperCase() === "TRUE") {
          namaLengkap = dataPengguna[i][2];
          cache.put(cacheKey, namaLengkap, 21600);
          break;
        } else {
          throw new Error("LOGIC_ERR:Kartu Tidak Aktif");
        }
      }
    }
  }

  if (!namaLengkap) throw new Error("LOGIC_ERR:RFID Tidak Terdaftar");

  const now = new Date();
  const tglHariIni = now.getDate();
  const timeStr = Utilities.formatDate(
    now,
    Session.getScriptTimeZone(),
    "HH:mm:ss"
  );
  const targetSheetName = NAMA_BULAN[now.getMonth()];

  const sheetReport = ss.getSheetByName(targetSheetName);
  if (!sheetReport) throw new Error(`Sheet '${targetSheetName}' belum dibuat!`);

  const config = getConfig(ss);
  let kategori = null;
  let statusCode = "";
  let statusText = "";

  if (mode === "SEKOLAH") {
    if (isTimeInRange(timeStr, config["WaktuDatang"])) {
      kategori = "Datang";
      statusCode = "H";
      statusText = "Hadir Sekolah";
    } else if (isTimeInRange(timeStr, config["WaktuTerlambat"])) {
      kategori = "Datang";
      statusCode = "T";
      statusText = "Terlambat";
    } else if (isTimeInRange(timeStr, config["WaktuPulang"])) {
      kategori = "Pulang";
      statusCode = "P";
      statusText = "Pulang Sekolah";
    } else {
      throw new Error(`LOGIC_ERR:Diluar Jam Sekolah (${timeStr})`);
    }
  } else {
    if (isTimeInRange(timeStr, config["WaktuSubuh"])) {
      kategori = "Subuh";
      statusCode = "H";
    } else if (isTimeInRange(timeStr, config["WaktuDzuhur"])) {
      kategori = "Dzuhur";
      statusCode = "H";
    } else if (isTimeInRange(timeStr, config["WaktuAshar"])) {
      kategori = "Ashar";
      statusCode = "H";
    } else if (isTimeInRange(timeStr, config["WaktuMaghrib"])) {
      kategori = "Maghrib";
      statusCode = "H";
    } else if (isTimeInRange(timeStr, config["WaktuIsya"])) {
      kategori = "Isya";
      statusCode = "H";
    } else if (isTimeInRange(timeStr, config["WaktuTahajjud"])) {
      kategori = "Tahajjud";
      statusCode = "H";
    } else if (isTimeInRange(timeStr, config["WaktuDhuha"])) {
      kategori = "Dhuha";
      statusCode = "H";
    } else {
      throw new Error(`LOGIC_ERR:Diluar Jam Sholat (${timeStr})`);
    }

    if (kategori) statusText = "Hadir Sholat " + kategori;
  }

  if (ACTIVITY_OFFSET[kategori] === undefined)
    throw new Error(`Mapping kolom error.`);

  const dataReport = sheetReport.getDataRange().getValues();
  let targetRowIndex = -1;

  for (let r = 3; r < dataReport.length; r++) {
    if (
      String(dataReport[r][1]).toLowerCase() ===
      String(namaLengkap).toLowerCase()
    ) {
      targetRowIndex = r + 1;
      break;
    }
  }

  if (targetRowIndex === -1)
    throw new Error(
      `LOGIC_ERR:Nama '${namaLengkap}' tidak ada di sheet ${targetSheetName}.`
    );

  const headerDates = dataReport[1];
  let dateColStartIndex = -1;
  for (let c = 0; c < headerDates.length; c++) {
    if (String(headerDates[c]) == String(tglHariIni)) {
      dateColStartIndex = c + 1;
      break;
    }
  }

  if (dateColStartIndex === -1)
    throw new Error(`LOGIC_ERR:Kolom Tanggal '${tglHariIni}' tidak ditemukan.`);

  const finalColIndex = dateColStartIndex + ACTIVITY_OFFSET[kategori];
  const cell = sheetReport.getRange(targetRowIndex, finalColIndex);

  if (!cell.isBlank()) {
    const existingVal = cell.getValue();
    throw new Error(`LOGIC_ERR:Sudah Absen (${existingVal})`);
  }

  cell.setValue(statusCode);
  cell.setNote(`Tap: ${timeStr} [${mode}]`);

  return { nama: namaLengkap, waktu: timeStr, status: statusText, mode: mode };
}

function getConfig(ss) {
  const sheet = ss.getSheetByName(SHEET_PENGATURAN);
  const data = sheet.getDataRange().getValues();
  const config = {};
  for (let i = 1; i < data.length; i++) {
    if (data[i][0]) config[data[i][0]] = data[i][1];
  }
  return config;
}

function isTimeInRange(curr, range) {
  if (!range) return false;
  const p = range.split("-");
  if (p.length !== 2) return false;
  const s = p[0].trim(),
    e = p[1].trim();
  return s <= e ? curr >= s && curr <= e : curr >= s || curr <= e;
}

```
---

## ./tsconfig.json

```json
{
  "extends": "astro/tsconfigs/strict",
  "include": [".astro/types.d.ts", "**/*"],
  "exclude": ["dist"]
}

```
---

## ./src/pages/index.astro

```html
---
import Layout from '../layouts/Layout.astro';

// Mengambil URL dari .env saat build/runtime
const API_URL = import.meta.env.PUBLIC_API_URL;
---

<Layout title="Sistem Presensi">
	<!-- Background Wrapper -->
	<div id="bg-image" class="fixed inset-0 z-[-1] bg-cover bg-center bg-no-repeat opacity-40 blur-sm scale-110 transition-all duration-700"></div>
    <div class="fixed inset-0 z-[-1] bg-slate-900/60"></div>

	<main class="min-h-[100dvh] flex items-center justify-center p-4">
		<div class="bg-slate-800/80 backdrop-blur-xl border border-white/10 rounded-3xl p-6 w-full max-w-md text-center shadow-2xl relative transition-all duration-300">
			
            <!-- Mode Switcher -->
			<div class="flex bg-black/30 rounded-xl p-1 mb-6 gap-1">
				<button id="btnSekolah" class="flex-1 py-3 px-3 rounded-lg text-sm font-semibold transition-all bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 active:scale-95">
					🏫 SEKOLAH
				</button>
				<button id="btnSholat" class="flex-1 py-3 px-3 rounded-lg text-sm font-semibold text-slate-400 hover:text-white transition-all active:scale-95">
					🕌 SHOLAT
				</button>
			</div>

            <!-- Logo & Title -->
			<img id="appLogo" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxIDEiPjwvc3ZnPg==" class="w-24 h-24 object-contain mx-auto mb-2 drop-shadow-lg" alt="Logo" />
			<h1 id="appInstansi" class="text-xl font-bold leading-tight min-h-[1.75rem] animate-pulse">Memuat...</h1>
			<p class="text-slate-400 text-xs mt-1 mb-4">Sistem Presensi RFID <span id="modeStatus" class="font-semibold text-indigo-400">Reguler</span></p>

            <!-- Clock -->
			<div id="clock" class="text-5xl font-bold tracking-wider my-4 tabular-nums drop-shadow-[0_0_15px_rgba(255,255,255,0.1)]">00:00:00</div>
			<div id="date" class="text-sm text-slate-300 mb-6">-</div>

            <!-- Hidden Input -->
			<input type="text" id="rfidInput" autocomplete="off" inputmode="none" class="opacity-0 absolute -top-[1000px] pointer-events-none" autofocus />

            <!-- Status Box -->
			<div id="statusBox" class="mt-4 p-4 rounded-2xl bg-white/5 min-h-[85px] flex flex-col justify-center items-center transition-all border border-transparent">
				<div id="loader" class="hidden w-8 h-8 border-4 border-white/10 border-t-white rounded-full animate-spin mb-2"></div>
				<div id="resultContent">
					<div class="text-[10px] uppercase tracking-widest text-slate-400 mb-1">STATUS</div>
					<div id="statusMsg" class="text-xl font-bold">MENUNGGU KARTU...</div>
                    <div id="statusDesc" class="text-xs text-slate-400 mt-1"></div>
				</div>
			</div>

            <!-- Queue Info -->
			<div id="queueInfo" class="flex justify-center items-center gap-2 mt-4 h-6 opacity-0 transition-opacity duration-300">
				<span class="text-xs font-medium text-amber-400 animate-pulse">⏳ Antrian: <span id="queueCount">0</span></span> 
				<span id="offlineBadge" class="hidden bg-red-500 text-white px-2 py-0.5 rounded text-[10px] font-bold tracking-wide">OFFLINE</span>
			</div>

            <!-- Footer -->
			<footer class="mt-8 pt-4 border-t border-white/5 text-[10px] text-slate-500 flex justify-between px-2">
                <span>Ver <span id="appVersion">1.0</span></span>
                <span>By <span id="appAuthor" class="text-indigo-400">Dev</span></span>
			</footer>
		</div>
	</main>

    <!-- INSTALL MODAL (PWA) -->
    <div id="installModal" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/80 backdrop-blur-sm hidden transition-all duration-300 opacity-0">
        <div class="bg-slate-800 w-full max-w-sm sm:rounded-3xl rounded-t-3xl border-t sm:border border-white/10 p-6 shadow-2xl transform translate-y-full sm:translate-y-0 transition-transform duration-300" id="modalContent">
            
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-white">Install Aplikasi</h3>
                <button id="closeModal" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            
            <p class="text-sm text-slate-300 mb-6 leading-relaxed">
                Pasang aplikasi ini ke layar utama untuk pengalaman <strong>Full Screen</strong> yang lebih cepat dan stabil.
            </p>

            <!-- Android / Desktop Trigger -->
            <button id="btnInstallNative" class="hidden w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold shadow-lg shadow-indigo-500/25 mb-3 transition-all active:scale-95 flex justify-center items-center gap-2">
                <span>⬇️</span> Install Sekarang
            </button>

            <!-- iOS Instructions -->
            <div id="iosInstructions" class="hidden bg-white/5 rounded-xl p-4 text-left space-y-3">
                <div class="flex items-start gap-3 text-sm text-slate-300">
                    <span class="text-xl">1️⃣</span>
                    <span>Tekan tombol <strong>Share</strong> <span class="inline-block text-lg">🛫</span> di menu browser bawah.</span>
                </div>
                <div class="flex items-start gap-3 text-sm text-slate-300">
                    <span class="text-xl">2️⃣</span>
                    <span>Geser menu ke atas, pilih <strong>Add to Home Screen</strong> (Tambah ke Utama).</span>
                </div>
            </div>

            <button id="btnLater" class="w-full py-3 mt-2 text-sm text-slate-400 hover:text-white">
                Nanti Saja
            </button>
        </div>
    </div>
</Layout>

<!-- Meneruskan variabel environment ke script client-side -->
<script define:vars={{ API_URL }}>
    // --- STATE VARIABLES ---
    let queue = [];
    let isSyncing = false;
    let currentMode = "SEKOLAH";
    let isOnline = navigator.onLine;
    let deferredPrompt = null; // Untuk menyimpan event install native

    // --- DOM ELEMENTS ---
    const els = {
        input: document.getElementById("rfidInput"),
        statusBox: document.getElementById("statusBox"),
        loader: document.getElementById("loader"),
        resultContent: document.getElementById("resultContent"),
        statusMsg: document.getElementById("statusMsg"),
        statusDesc: document.getElementById("statusDesc"),
        queueInfo: document.getElementById("queueInfo"),
        queueCount: document.getElementById("queueCount"),
        offlineBadge: document.getElementById("offlineBadge"),
        btnSekolah: document.getElementById("btnSekolah"),
        btnSholat: document.getElementById("btnSholat"),
        modeStatus: document.getElementById("modeStatus"),
        bgImage: document.getElementById("bg-image"),
        appLogo: document.getElementById("appLogo"),
        appInstansi: document.getElementById("appInstansi"),
        appVersion: document.getElementById("appVersion"),
        appAuthor: document.getElementById("appAuthor"),
        clock: document.getElementById("clock"),
        date: document.getElementById("date"),
        // Modal Elements
        installModal: document.getElementById("installModal"),
        modalContent: document.getElementById("modalContent"),
        btnInstallNative: document.getElementById("btnInstallNative"),
        iosInstructions: document.getElementById("iosInstructions"),
        closeModal: document.getElementById("closeModal"),
        btnLater: document.getElementById("btnLater"),
    };

    // --- INITIALIZATION ---
    async function initApp() {
        if(!API_URL) {
            console.error("API_URL belum diset di .env");
            els.appInstansi.innerText = "Error Config .env";
            return;
        }

        try {
            const res = await fetch(API_URL);
            const json = await res.json();
            
            if(json.status === 'success') {
                const cfg = json.data;
                if(cfg.Background) els.bgImage.style.backgroundImage = `url('${cfg.Background}')`;
                if(cfg.Logo) els.appLogo.src = cfg.Logo;
                if(cfg.Instansi) {
                    els.appInstansi.innerText = cfg.Instansi;
                    els.appInstansi.classList.remove('animate-pulse');
                }
                if(cfg.VersiAplikasi) els.appVersion.innerText = cfg.VersiAplikasi;
                if(cfg.Author) els.appAuthor.innerText = cfg.Author;
            }
        } catch (e) {
            console.error("Gagal load config", e);
            els.appInstansi.innerText = "Mode Offline";
            els.appInstansi.classList.remove('animate-pulse');
        }

        setupEvents();
        checkPWAStatus();
        focusInput();
    }

    // --- PWA INSTALL LOGIC ---
    function checkPWAStatus() {
        // Cek apakah sudah mode standalone (sudah diinstall)
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || (window.navigator).standalone;
        
        if (isStandalone) return; // Jika sudah install, jangan lakukan apa-apa

        // Deteksi iOS
        const ua = navigator.userAgent;
        const isIOS = /iPad|iPhone|iPod/.test(ua) && !(window).MSStream;

        if (isIOS) {
            // iOS tidak punya event beforeinstallprompt, jadi kita tampilkan panduan manual setelah delay
            setTimeout(() => {
                showInstallModal('ios');
            }, 3000);
        }
        
        // Untuk Android/Desktop, kita tunggu event 'beforeinstallprompt' (lihat di setupEvents)
    }

    function showInstallModal(type) {
        els.installModal.classList.remove('hidden');
        // Animasi masuk
        setTimeout(() => {
            els.installModal.classList.remove('opacity-0');
            els.modalContent.classList.remove('translate-y-full');
        }, 10);

        if (type === 'native') {
            els.btnInstallNative.classList.remove('hidden');
            els.iosInstructions.classList.add('hidden');
        } else {
            els.btnInstallNative.classList.add('hidden');
            els.iosInstructions.classList.remove('hidden');
        }
    }

    function hideInstallModal() {
        els.installModal.classList.add('opacity-0');
        els.modalContent.classList.add('translate-y-full');
        setTimeout(() => {
            els.installModal.classList.add('hidden');
            focusInput(); // Kembalikan fokus ke input
        }, 300);
    }

    // --- EVENT LISTENERS ---
    function setupEvents() {
        // 1. Handle PWA Install Prompt (Android/Desktop)
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault(); // Mencegah bar bawaan browser muncul
            deferredPrompt = e; // Simpan event untuk dipanggil nanti
            
            // Tampilkan modal custom kita setelah beberapa detik
            setTimeout(() => {
                showInstallModal('native');
            }, 3000);
        });

        // 2. Handle Tombol Install di Modal
        els.btnInstallNative.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt(); // Panggil prompt asli browser
                const { outcome } = await deferredPrompt.userChoice;
                deferredPrompt = null;
                hideInstallModal();
            }
        });

        // 3. Handle Tutup Modal
        els.closeModal.addEventListener('click', hideInstallModal);
        els.btnLater.addEventListener('click', hideInstallModal);

        // 4. Prevent close tab jika antrian ada
        window.addEventListener("beforeunload", (e) => {
            if (queue.length > 0) { e.preventDefault(); e.returnValue = ""; }
        });

        // 5. Network Monitor
        window.addEventListener("online", () => updateOnlineStatus(true));
        window.addEventListener("offline", () => updateOnlineStatus(false));

        // 6. Input Listener
        els.input.addEventListener("change", (e) => {
            const target = e.target;
            const rfid = target.value.trim();
            target.value = "";
            if (rfid.length > 0) addToQueue(rfid);
        });
        
        // 7. Focus Keeper
        document.addEventListener("click", focusInput);
        
        // 8. Mode Buttons
        els.btnSekolah.onclick = () => setMode("SEKOLAH");
        els.btnSholat.onclick = () => setMode("SHOLAT");

        // 9. Watchdog
        setInterval(() => {
            if (queue.length > 0 && isOnline && !isSyncing) processQueue();
        }, 5000);
    }

    // --- LOGIC UTAMA (SAMA SEPERTI SEBELUMNYA) ---
    function setMode(mode) {
        currentMode = mode;
        const activeClass = "bg-indigo-600 text-white shadow-lg shadow-indigo-500/30";
        const inactiveClass = "text-slate-400 hover:text-white";
        const sholatActiveClass = "bg-pink-600 text-white shadow-lg shadow-pink-500/30";

        if (mode === 'SEKOLAH') {
            els.btnSekolah.className = `flex-1 py-3 px-3 rounded-lg text-sm font-semibold transition-all active:scale-95 ${activeClass}`;
            els.btnSholat.className = `flex-1 py-3 px-3 rounded-lg text-sm font-semibold transition-all active:scale-95 ${inactiveClass}`;
            els.modeStatus.innerText = "Reguler (Sekolah)";
            els.modeStatus.className = "font-semibold text-indigo-400";
        } else {
            els.btnSekolah.className = `flex-1 py-3 px-3 rounded-lg text-sm font-semibold transition-all active:scale-95 ${inactiveClass}`;
            els.btnSholat.className = `flex-1 py-3 px-3 rounded-lg text-sm font-semibold transition-all active:scale-95 ${sholatActiveClass}`;
            els.modeStatus.innerText = "Kegiatan Ibadah";
            els.modeStatus.className = "font-semibold text-pink-400";
        }
        setTimeout(focusInput, 100);
    }

    function addToQueue(rfid) {
        queue.push({ rfid, mode: currentMode });
        updateQueueDisplay();
        if (queue.length === 1 && isOnline) showLoadingUI();
        processQueue();
    }

    async function processQueue() {
        if (!navigator.onLine) { isSyncing = false; updateOnlineStatus(false); return; }
        if (isSyncing || queue.length === 0) return;

        isSyncing = true;
        const currentData = queue[0];

        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                body: JSON.stringify(currentData)
            });
            const res = await response.json();

            if (res.status === 'success') {
                showSuccessUI(res.data);
                queue.shift();
                finishSync();
            } else {
                handleFailure({ message: res.message });
            }
        } catch (error) {
            handleFailure({ message: "Gagal koneksi server" });
        }
    }

    function handleFailure(err) {
        const msg = err.message || "Unknown Error";
        if (msg.includes("LOGIC_ERR")) {
            showFailureUI({ message: msg.replace("LOGIC_ERR:", "") });
            queue.shift(); 
            finishSync();
        } else {
            showFailureUI({ message: "Koneksi tidak stabil..." });
            isSyncing = false;
            updateOnlineStatus(false);
        }
    }

    function finishSync() {
        isSyncing = false;
        updateQueueDisplay();
        if (queue.length > 0) setTimeout(processQueue, 1500);
        else setTimeout(resetUI, 2500);
    }

    // --- UI UPDATERS ---
    function updateOnlineStatus(status) {
        isOnline = status;
        if (isOnline) {
            els.offlineBadge.classList.add('hidden');
            isSyncing = false;
            if (queue.length > 0) setTimeout(processQueue, 2000);
        } else {
            els.offlineBadge.classList.remove('hidden');
            els.queueInfo.classList.remove('opacity-0');
            isSyncing = false;
        }
        updateQueueDisplay();
    }

    function updateQueueDisplay() {
        els.queueCount.innerText = queue.length.toString();
        if (queue.length > 0 || !isOnline) els.queueInfo.classList.remove('opacity-0');
        else els.queueInfo.classList.add('opacity-0');
    }

    function showLoadingUI() {
        els.statusBox.className = "mt-4 p-4 rounded-2xl bg-white/5 min-h-[85px] flex flex-col justify-center items-center border border-white/20";
        els.resultContent.classList.add('hidden');
        els.loader.classList.remove('hidden');
    }

    function showSuccessUI(data) {
        els.loader.classList.add('hidden');
        els.resultContent.classList.remove('hidden');
        els.statusBox.className = "mt-4 p-4 rounded-2xl bg-green-500/10 min-h-[85px] flex flex-col justify-center items-center border border-green-500/50 shadow-[0_0_20px_rgba(34,197,94,0.2)]";
        els.resultContent.innerHTML = `
            <div class="text-[10px] uppercase tracking-widest text-green-400 mb-1">BERHASIL (${data.mode})</div>
            <div class="text-xl font-bold text-white">${data.nama}</div>
            <div class="text-xs text-slate-300 mt-1">${data.status}</div>
        `;
    }

    function showFailureUI(data) {
        els.loader.classList.add('hidden');
        els.resultContent.classList.remove('hidden');
        els.statusBox.className = "mt-4 p-4 rounded-2xl bg-red-500/10 min-h-[85px] flex flex-col justify-center items-center border border-red-500/50 shadow-[0_0_20px_rgba(239,68,68,0.2)]";
        els.resultContent.innerHTML = `
            <div class="text-[10px] uppercase tracking-widest text-red-400 mb-1">GAGAL</div>
            <div class="text-xl font-bold text-white">PERINGATAN</div>
            <div class="text-xs text-red-200 mt-1">${data.message}</div>
        `;
    }

    function resetUI() {
        if (queue.length > 0 || isSyncing) return;
        els.statusBox.className = "mt-4 p-4 rounded-2xl bg-white/5 min-h-[85px] flex flex-col justify-center items-center border border-transparent";
        els.resultContent.innerHTML = `
            <div class="text-[10px] uppercase tracking-widest text-slate-400 mb-1">STATUS</div>
            <div class="text-xl font-bold">MENUNGGU KARTU...</div>
            <div class="text-xs text-slate-400 mt-1"></div>
        `;
    }

    function focusInput() {
        if (document.activeElement !== els.input) els.input.focus();
    }

    setInterval(() => {
        const now = new Date();
        els.clock.innerText = now.toLocaleTimeString("id-ID", { hour12: false });
        els.date.innerText = now.toLocaleDateString("id-ID", { weekday: "long", day: "numeric", month: "long", year: "numeric" });
    }, 1000);

    // Initial Load
    initApp();
</script>
```
---

## ./src/styles/global.css

```css
@import "tailwindcss";
```
---

## ./src/layouts/Layout.astro

```html
---
import "../styles/global.css";

interface Props {
	title: string;
}

const { title } = Astro.props;
---

<!doctype html>
<html lang="id">
	<head>
		<meta charset="UTF-8" />
		<meta name="description" content="Sistem Presensi RFID Sekolah dan Sholat" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover" />
		<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600&display=swap" rel="stylesheet" />
        
        <!-- PWA Manifest & Meta -->
        <link rel="manifest" href="/manifest.json" />
        <meta name="theme-color" content="#0f172a" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Presensi">

		<title>{title}</title>
	</head>
	<body class="bg-slate-900 text-slate-50 font-['Lexend'] overflow-hidden select-none min-h-screen">
		<slot />
        
        <!-- Register Service Worker -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js');
                });
            }
        </script>
	</body>
</html>

<style is:global>
    * { -webkit-tap-highlight-color: transparent; }
</style>
```
---

## ./.env

```
PUBLIC_API_URL=https://script.google.com/macros/s/AKfycbzE7XJ4YP2joBa-nfE-uvmCcAJ_glJ9VbNjM9dKZKHiOUGDZWXp8pIHErOzwNDafIoy/exec
```
---

## ./public/manifest.json

```json
{
  "name": "Sistem Presensi RFID",
  "short_name": "Presensi",
  "description": "Aplikasi Presensi RFID Sekolah dan Sholat",
  "start_url": "/",
  "display": "standalone",
  "background_color": "#0f172a",
  "theme_color": "#0f172a",
  "orientation": "portrait",
  "icons": [
    {
      "src": "/icons/192x192.png",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "/icons/512x512.png",
      "sizes": "512x512",
      "type": "image/png"
    }
  ]
}

```
---

## ./public/sw.js

```javascript
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

```
---

