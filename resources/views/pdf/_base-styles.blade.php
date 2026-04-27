<style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
        color: #1a1a1a;
        padding: 1.5cm 2cm 2cm;
        line-height: 1.65;
    }

    /* ── KOP ──────────────────────────────────────────────────── */
    .kop-surat {
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 4px double #1a1a1a;
        padding-bottom: 10px;
        margin-bottom: 18px;
    }

    .kop-surat img {
        height: 80px;
        width: 80px;
        object-fit: contain;
    }

    .kop-text {
        flex: 1;
        text-align: center;
    }

    .kop-text h1 {
        font-size: 15pt;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .kop-text p {
        font-size: 10pt;
        color: #444;
        margin-top: 2px;
    }

    /* ── JUDUL ────────────────────────────────────────────────── */
    h2.judul {
        text-align: center;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 18px 0 20px;
    }

    /* ── NOMOR / META ─────────────────────────────────────────── */
    table.nomor {
        margin-bottom: 16px;
        font-size: 11pt;
    }

    table.nomor td {
        padding: 2px 6px 2px 0;
        vertical-align: top;
    }

    table.nomor td.lbl {
        width: 5cm;
        color: #555;
    }

    table.nomor td.sep {
        width: .3cm;
    }

    /* ── DATA SISWA ───────────────────────────────────────────── */
    table.data {
        width: 100%;
        margin-bottom: 16px;
        font-size: 11pt;
        border-collapse: collapse;
    }

    table.data td {
        padding: 3px 6px 3px 0;
        vertical-align: top;
    }

    table.data td.lbl {
        width: 5.5cm;
        color: #555;
    }

    table.data td.sep {
        width: .3cm;
    }

    table.data td.val {
        font-weight: bold;
    }

    /* ── ISI ──────────────────────────────────────────────────── */
    .isi p {
        text-indent: 1.5cm;
        margin-bottom: 10px;
        text-align: justify;
    }

    /* ── TTD ──────────────────────────────────────────────────── */
    .ttd-block {
        display: flex;
        justify-content: flex-end;
        margin-top: 32px;
    }

    .ttd-inner {
        text-align: center;
        width: 7cm;
        font-size: 11pt;
    }

    .ttd-inner img {
        height: 72px;
        margin: 6px auto;
        display: block;
        object-fit: contain;
    }

    .ttd-inner .ttd-space {
        height: 72px;
    }

    .ttd-inner .ttd-nama {
        font-weight: bold;
        text-decoration: underline;
    }

    .ttd-inner .ttd-nip {
        font-size: 10pt;
        color: #444;
    }

    /* ── QR ───────────────────────────────────────────────────── */
    .qr-box {
        margin-top: 28px;
        text-align: center;
        border-top: 1px dashed #ccc;
        padding-top: 14px;
    }

    .qr-box img {
        width: 90px;
        height: 90px;
    }

    .qr-box p {
        font-size: 9pt;
        color: #666;
        margin-top: 4px;
    }
</style>
