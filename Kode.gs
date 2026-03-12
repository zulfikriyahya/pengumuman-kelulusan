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
