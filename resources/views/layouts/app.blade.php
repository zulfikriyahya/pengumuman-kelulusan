<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ── SEO Primary ──────────────────────────────────────── --}}
    @php
        $seoTitle = trim(
            implode(' — ', array_filter([View::yieldContent('title'), $instansi?->nama ?? config('app.name')])),
        );
        $seoDesc = $instansi
            ? 'Cek status kelulusan, unduh SKL dan surat undangan wisuda ' .
                $instansi->nama .
                ' secara online — cepat, resmi, gratis.'
            : 'Layanan pengumuman kelulusan digital madrasah — cek status, unduh SKL dan undangan wisuda.';
        $seoUrl = url()->current();
        $seoImage = $instansi?->logo_institusi ? Storage::url($instansi->logo_institusi) : asset('icons/icon-512.png');
        $seoSiteName = $instansi?->nama ?? config('app.name');
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDesc }}">
    <meta name="keywords" content="pengumuman kelulusan, SKL, surat keterangan lulus, madrasah, {{ $seoSiteName }}">
    <meta name="author" content="{{ $seoSiteName }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $seoUrl }}">

    {{-- ── Open Graph ───────────────────────────────────────── --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:site_name" content="{{ $seoSiteName }}">
    <meta property="og:locale" content="id_ID">

    {{-- ── Twitter Card ─────────────────────────────────────── --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    {{-- <style>
        /* ── RESET ─────────────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ── TOKENS ────────────────────────────────────────────────── */
        :root {
            --teal: #0d9488;
            --teal-l: #14b8a6;
            --teal-d: #0f766e;
            --teal-xl: #2dd4bf;
            --gold: #c49a28;
            --gold-l: #e6b84a;
            --bg: #030b09;
            --bg2: #060f0c;
            --surface: #091310;
            --card: rgba(20, 184, 166, .055);
            --card2: rgba(255, 255, 255, .03);
            --border: rgba(20, 184, 166, .13);
            --border2: rgba(255, 255, 255, .055);
            --text: #eaf5f2;
            --muted: #5f9e95;
            --muted2: #3d706a;
            --radius: 14px;
            --nav-h: 64px;
            /* sedikit lebih tinggi */
            --font-display: 'Lexend', system-ui, sans-serif;
            --font-body: 'Lexend', system-ui, sans-serif;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
            min-height: 100svh;
        }

        ::-webkit-scrollbar {
            width: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--teal);
            border-radius: 3px;
        }

        /* ── AMBIENT ───────────────────────────────────────────────── */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(160px);
            opacity: .065;
            pointer-events: none;
            z-index: 0;
            animation: orb-drift 20s ease-in-out infinite alternate;
        }

        .orb-1 {
            width: 680px;
            height: 680px;
            background: radial-gradient(circle, var(--teal), transparent 70%);
            top: -260px;
            left: -220px;
        }

        .orb-2 {
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, var(--gold), transparent 70%);
            bottom: -160px;
            right: -180px;
            animation-delay: -10s;
        }

        @keyframes orb-drift {
            to {
                transform: translate(28px, 18px) scale(1.07);
            }
        }

        .grid-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(13, 148, 136, .035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(13, 148, 136, .035) 1px, transparent 1px);
            background-size: 56px 56px;
            mask-image: radial-gradient(ellipse 80% 55% at 50% 0%, black 35%, transparent 100%);
        }

        /* ── NAV ───────────────────────────────────────────────────── */
        nav#mainNav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            height: var(--nav-h);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            background: rgba(3, 11, 9, .88);
            border-bottom: 1px solid rgba(20, 184, 166, .1);
            backdrop-filter: blur(32px) saturate(180%);
            transition: background .3s, box-shadow .3s;
        }

        nav#mainNav.scrolled {
            background: rgba(3, 11, 9, .97);
            box-shadow: 0 1px 0 rgba(20, 184, 166, .1), 0 6px 40px rgba(0, 0, 0, .5);
        }

        /* Brand */
        .nav-brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            text-decoration: none;
            color: inherit;
            flex-shrink: 0;
            min-width: 0;
        }

        .nav-logo {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1.5px solid rgba(20, 184, 166, .35);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(13, 148, 136, .1);
            box-shadow: 0 0 18px rgba(13, 148, 136, .2), inset 0 1px 0 rgba(94, 234, 212, .1);
        }

        .nav-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
        }

        .nav-logo-fallback {
            font-size: .68rem;
            font-weight: 800;
            color: var(--teal-xl);
            font-family: var(--font-display);
        }

        .nav-brand-text {
            min-width: 0;
        }

        .nav-name {
            font-size: .78rem;
            font-weight: 900;
            /* naik dari 800 */
            letter-spacing: .05em;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-family: var(--font-display);
            max-width: 260px;
            color: #fff;
            /* putih penuh */
        }

        .nav-sub {
            font-size: .58rem;
            font-weight: 700;
            color: var(--gold-l);
            /* kuning/gold seperti site daftar */
            margin-top: 1px;
            letter-spacing: .04em;
            white-space: nowrap;
            text-transform: uppercase;
        }

        /* Centre links */
        .nav-links {
            display: flex;
            gap: .05rem;
            list-style: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(234, 245, 242, .55);
            font-size: .77rem;
            font-weight: 600;
            padding: .4rem .82rem;
            border-radius: 8px;
            transition: all .2s;
            white-space: nowrap;
            letter-spacing: .01em;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #fff;
            background: rgba(20, 184, 166, .1);
        }

        .nav-links a.nav-tamu {
            color: var(--gold-l);
        }

        .nav-links a.nav-tamu:hover,
        .nav-links a.nav-tamu.active {
            color: var(--gold-l);
            background: rgba(212, 168, 67, .1);
        }

        /* Right side */
        .nav-right {
            display: flex;
            align-items: center;
            gap: .45rem;
            flex-shrink: 0;
        }

        .n-btn {
            height: 34px;
            padding: 0 .9rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--card2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .76rem;
            color: inherit;
            transition: all .2s;
            white-space: nowrap;
            font-weight: 600;
            font-family: var(--font-body);
            text-decoration: none;
            letter-spacing: .01em;
        }

        .n-btn:hover {
            border-color: var(--teal);
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .09);
        }

        .n-btn-primary {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 0 18px rgba(220, 38, 38, .25);
            font-weight: 800;
            font-size: .75rem;
            letter-spacing: .02em;
        }

        .n-btn-primary:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 24px rgba(220, 38, 38, .4);
        }

        .n-btn-primary.state-open {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            box-shadow: 0 0 18px rgba(13, 148, 136, .25);
        }

        .n-btn-primary.state-open:hover {
            box-shadow: 0 4px 24px rgba(13, 148, 136, .42);
        }

        /* Hamburger */
        #menuBtn {
            width: 34px;
            height: 34px;
            flex-direction: column;
            gap: 5px;
            display: none;
            /* shown via media query */
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            padding: 0;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        #menuBtn:hover {
            border-color: var(--teal);
            background: rgba(20, 184, 166, .09);
        }

        #menuBtn span {
            display: block;
            width: 15px;
            height: 1.5px;
            background: currentColor;
            border-radius: 2px;
            transition: all .28s cubic-bezier(.4, 0, .2, 1);
        }

        #menuBtn.open span:nth-child(1) {
            transform: translateY(6.5px) rotate(45deg);
        }

        #menuBtn.open span:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }

        #menuBtn.open span:nth-child(3) {
            transform: translateY(-6.5px) rotate(-45deg);
        }

        /* ── MOBILE DRAWER ─────────────────────────────────────────── */
        .drawer {
            position: fixed;
            top: var(--nav-h);
            left: 0;
            right: 0;
            z-index: 190;
            display: flex;
            flex-direction: column;
            gap: .25rem;
            background: rgba(6, 13, 12, .97);
            border-bottom: 1px solid transparent;
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s cubic-bezier(.4, 0, .2, 1), padding .3s, border-color .3s;
            backdrop-filter: blur(20px);
            padding: 0 1.25rem;
        }

        .drawer.open {
            max-height: 420px;
            padding: .75rem 1.25rem 1.5rem;
            border-color: var(--border);
        }

        .drawer a {
            text-decoration: none;
            color: var(--muted);
            font-size: .84rem;
            font-weight: 600;
            padding: .6rem .85rem;
            border-radius: 9px;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .drawer a:hover {
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .07);
        }

        .drawer a.active {
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .06);
        }

        .drawer a.drawer-tamu {
            color: var(--gold-l);
        }

        .drawer a.drawer-tamu:hover {
            color: var(--gold-l);
            background: rgba(212, 168, 67, .08);
        }

        .drawer-divider {
            height: 1px;
            background: var(--border2);
            margin: .35rem 0;
        }

        /* ── PAGE ──────────────────────────────────────────────────── */
        .page-wrap {
            position: relative;
            z-index: 1;
            padding-top: var(--nav-h);
        }

        .content-wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        /* ── FLASH ─────────────────────────────────────────────────── */
        .flash-area {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .flash-msg {
            margin-top: .85rem;
        }

        .flash-inner {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .7rem;
            padding: .8rem 1rem;
            border-radius: 11px;
            font-size: .8rem;
            font-weight: 500;
            opacity: 0;
            transform: translateY(4px);
            transition: opacity .3s, transform .3s;
        }

        .flash-inner button {
            opacity: .45;
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            font-size: 1rem;
            line-height: 1;
            flex-shrink: 0;
            padding: 0;
            transition: opacity .2s;
        }

        .flash-inner button:hover {
            opacity: 1;
        }

        .flash-success {
            background: rgba(20, 184, 166, .09);
            border: 1px solid rgba(20, 184, 166, .22);
            color: var(--teal-xl);
        }

        .flash-error {
            background: rgba(220, 38, 38, .08);
            border: 1px solid rgba(220, 38, 38, .2);
            color: #f87171;
        }

        .flash-warning {
            background: rgba(245, 158, 11, .08);
            border: 1px solid rgba(245, 158, 11, .2);
            color: #fbbf24;
        }

        .flash-info {
            background: rgba(96, 165, 250, .08);
            border: 1px solid rgba(96, 165, 250, .2);
            color: #93c5fd;
        }

        /* ── COMPONENTS ────────────────────────────────────────────── */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            backdrop-filter: blur(12px);
            transition: border-color .3s, transform .3s, box-shadow .3s;
        }

        .card-hover:hover {
            border-color: rgba(20, 184, 166, .3);
            transform: translateY(-3px);
            box-shadow: 0 10px 36px rgba(13, 148, 136, .12);
        }

        .badge {
            display: inline-block;
            padding: .2rem .75rem;
            border-radius: 999px;
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .28rem .85rem;
            border-radius: 999px;
            font-size: .66rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            background: rgba(20, 184, 166, .09);
            color: var(--teal-xl);
            border: 1px solid rgba(20, 184, 166, .22);
            margin-bottom: .8rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .65rem 1.5rem;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all .22s;
            white-space: nowrap;
            letter-spacing: -.005em;
            font-family: var(--font-body);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            box-shadow: 0 0 24px rgba(13, 148, 136, .24);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 32px rgba(13, 148, 136, .4);
        }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border2);
        }

        .btn-ghost:hover {
            color: var(--teal-xl);
            border-color: rgba(20, 184, 166, .4);
            background: rgba(20, 184, 166, .06);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #b8882a);
            color: #fff;
            box-shadow: 0 0 20px rgba(212, 168, 67, .2);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 28px rgba(212, 168, 67, .34);
        }

        /* ── FORM ──────────────────────────────────────────────────── */
        .field {
            display: flex;
            flex-direction: column;
            gap: .4rem;
        }

        .field label {
            font-size: .76rem;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: .01em;
        }

        .input {
            width: 100%;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: .62rem .95rem;
            font-size: .86rem;
            font-family: var(--font-body);
            color: var(--text);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .input::placeholder {
            color: var(--muted2);
        }

        .input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1);
        }

        .input-error {
            border-color: rgba(220, 38, 38, .4);
        }

        .error-msg {
            font-size: .72rem;
            color: #f87171;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        /* ── TABLE ─────────────────────────────────────────────────── */
        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl thead th {
            padding: .8rem 1rem;
            font-size: .66rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .tbl tbody tr {
            border-bottom: 1px solid var(--border2);
            transition: background .15s;
        }

        .tbl tbody tr:hover {
            background: rgba(13, 148, 136, .035);
        }

        .tbl tbody td {
            padding: .8rem 1rem;
            font-size: .83rem;
        }

        .tbl tbody tr:last-child {
            border-bottom: none;
        }

        /* ── REVEAL ────────────────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .5s ease, transform .5s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
        }

        .reveal-delay-1 {
            transition-delay: .1s;
        }

        .reveal-delay-2 {
            transition-delay: .18s;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border2);
            margin: 1.25rem 0;
        }

        /* ── MOBILE: card landing full-width ──────────────────────── */
        @media (max-width: 599px) {

            .search-card,
            .cd-card,
            .state-card,
            .hasil-wrap,
            .konfirmasi-wrap,
            .scan-wrap {
                max-width: 100% !important;
                border-radius: 14px;
            }

            .hero-section {
                padding: 3rem .5rem;
            }
        }

        /* ── FOOTER ────────────────────────────────────────────────── */
        footer.site-footer {
            border-top: 1px solid var(--border);
            padding: 1.75rem 2rem;
            text-align: center;
            font-size: .7rem;
            color: var(--muted2);
            position: relative;
            z-index: 1;
            letter-spacing: .01em;
        }

        /* ── PERSON MODAL ──────────────────────────────────────────── */
        .person-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 500;
            background: rgba(4, 10, 9, .78);
            backdrop-filter: blur(14px) saturate(140%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }

        .person-modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .person-modal {
            background: linear-gradient(145deg, #0c1a18, #091410);
            border: 1px solid rgba(20, 184, 166, .18);
            border-radius: 22px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .55), 0 0 0 1px rgba(20, 184, 166, .07), inset 0 1px 0 rgba(94, 234, 212, .06);
            width: 100%;
            max-width: 400px;
            transform: translateY(22px) scale(.97);
            transition: transform .28s cubic-bezier(.22, 1, .36, 1), opacity .25s ease;
            overflow: hidden;
            position: relative;
        }

        .person-modal-overlay.open .person-modal {
            transform: translateY(0) scale(1);
        }

        .modal-close {
            position: absolute;
            top: .85rem;
            right: .85rem;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            color: var(--muted);
            cursor: pointer;
            font-size: .85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            line-height: 1;
            padding: 0;
            font-family: var(--font-body);
            z-index: 2;
        }

        .modal-close:hover {
            background: rgba(220, 38, 38, .15);
            border-color: rgba(220, 38, 38, .3);
            color: #f87171;
        }

        /* Header strip */
        .modal-header-strip {
            height: 3px;
            background: linear-gradient(90deg, var(--teal), var(--gold-l), var(--teal-xl));
        }

        /* Avatar */
        .modal-avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1.5rem 1.25rem;
            gap: .75rem;
        }

        .modal-avatar-ring {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), var(--gold));
            padding: 2px;
            flex-shrink: 0;
        }

        .modal-avatar-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-avatar-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-avatar-fallback {
            font-size: 2rem;
            font-weight: 800;
            font-family: var(--font-display);
            color: var(--teal-xl);
        }

        .modal-name {
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: -.025em;
            font-family: var(--font-display);
            text-align: center;
            line-height: 1.25;
        }

        .modal-role-badge {
            display: inline-flex;
            align-items: center;
            padding: .28rem .85rem;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .06em;
            background: rgba(20, 184, 166, .1);
            border: 1px solid rgba(20, 184, 166, .2);
            color: var(--teal-xl);
        }

        .modal-role-badge.gold {
            background: rgba(212, 168, 67, .1);
            border-color: rgba(212, 168, 67, .2);
            color: var(--gold-l);
        }

        /* Body rows */
        .modal-body {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }

        .modal-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: .55rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
        }

        .modal-row:last-child {
            border-bottom: none;
        }

        .modal-row-label {
            font-size: .7rem;
            color: var(--muted);
            font-weight: 500;
            flex-shrink: 0;
        }

        .modal-row-val {
            font-size: .82rem;
            font-weight: 600;
            text-align: right;
            word-break: break-all;
        }

        .modal-row-mono {
            font-family: monospace;
            font-size: .8rem;
            color: var(--teal-xl);
        }

        .modal-quote {
            margin: .25rem 0 .5rem;
            padding: .75rem 1rem;
            border-left: 2px solid rgba(20, 184, 166, .3);
            font-size: .78rem;
            font-style: italic;
            color: var(--muted);
            line-height: 1.65;
            border-radius: 0 8px 8px 0;
            background: rgba(20, 184, 166, .03);
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border2);
            display: flex;
            gap: .5rem;
        }

        .modal-footer .btn {
            flex: 1;
            justify-content: center;
            font-size: .78rem;
            padding: .58rem;
        }

        /* Cursor on clickable cards */
        .person-card.clickable {
            cursor: pointer;
        }

        /* ── RESPONSIVE ────────────────────────────────────────────── */
        @media (max-width: 960px) {
            .nav-links {
                display: none !important;
            }

            #menuBtn {
                display: flex !important;
            }
        }

        /* Sembunyikan tombol Beranda di smartphone */
        @media (max-width: 768px) {
            .n-btn-primary.nav-home-btn {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            :root {
                --nav-h: 54px;
            }

            .content-wrap {
                padding: 1.75rem .65rem;
            }

            .nav-name {
                max-width: none;
                overflow: visible;
                text-overflow: unset;
                white-space: normal;
                line-height: 1.2;
                font-size: .72rem;
            }

            .people-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: .65rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: .75rem;
            }

            .search-form {
                width: 100%;
            }

            .search-field-wrap {
                flex: 1;
            }

            .search-field-input {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .tamu-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .tamu-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .doc-wrap {
                padding: 0 .25rem;
            }

            .doc-card .doc-body {
                padding: 1.1rem 1.2rem 1.5rem;
            }

            .kop-surat {
                padding: 1.25rem 1.2rem 1rem;
                gap: .65rem;
            }

            .kop-surat img {
                height: 52px;
                width: 52px;
            }

            .hasil-wrap {
                max-width: 100%;
            }

            .result-header,
            .result-info,
            .result-actions {
                padding-left: 1.1rem;
                padding-right: 1.1rem;
            }

            .tamu-table-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .tamu-tbl {
                min-width: 500px;
            }
        }

        @media (max-width: 540px) {
            :root {
                --nav-h: 50px;
            }

            .content-wrap {
                padding: 1.5rem .5rem;
            }

            .nav-sub {
                display: none;
            }

            .nav-name {
                font-size: .68rem;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .search-card {
                padding: 1.25rem 1rem;
            }

            .konfirmasi-wrap {
                max-width: 100%;
            }

            .scan-wrap {
                max-width: 100%;
            }

            .doc-toolbar {
                flex-direction: column;
                align-items: flex-start;
                gap: .5rem;
            }

            /* Modal full-width on small screens */
            .person-modal {
                max-width: 100%;
                border-radius: 18px 18px 0 0;
            }

            .person-modal-overlay {
                align-items: flex-end;
                padding: 0;
            }
        }

        @media print {

            .orb,
            .grid-bg,
            nav#mainNav,
            .drawer,
            .flash-area,
            footer.site-footer {
                display: none !important;
            }

            .page-wrap {
                padding-top: 0;
            }

            .content-wrap {
                padding: 0;
                max-width: 100%;
            }

            body {
                background: #fff;
                color: #000;
            }
        }
    </style> --}}

    <style>
        /* ── RESET ──────────────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ── TOKENS ─────────────────────────────────────────────────── */
        :root {
            --teal: #0d9488;
            --teal-l: #14b8a6;
            --teal-d: #0f766e;
            --teal-xl: #2dd4bf;
            --gold: #c49a28;
            --gold-l: #e6b84a;
            --bg: #030b09;
            --bg2: #060f0c;
            --surface: #091310;
            --card: rgba(20, 184, 166, .055);
            --card2: rgba(255, 255, 255, .03);
            --border: rgba(20, 184, 166, .13);
            --border2: rgba(255, 255, 255, .055);
            --text: #eaf5f2;
            --muted: #5f9e95;
            --muted2: #3d706a;
            --radius: 14px;
            --nav-h: 64px;
            --font-display: 'Lexend', system-ui, sans-serif;
            --font-body: 'Lexend', system-ui, sans-serif;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
            -webkit-overflow-scrolling: touch;
            min-height: 100svh;
        }

        ::-webkit-scrollbar {
            width: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--teal);
            border-radius: 3px;
        }

        /* ── AMBIENT ─────────────────────────────────────────────────── */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: .055;
            pointer-events: none;
            z-index: 0;
            will-change: transform;
            animation: orb-drift 20s ease-in-out infinite alternate;
        }

        .orb-1 {
            width: 680px;
            height: 680px;
            background: radial-gradient(circle, var(--teal), transparent 70%);
            top: -260px;
            left: -220px;
        }

        .orb-2 {
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, var(--gold), transparent 70%);
            bottom: -160px;
            right: -180px;
            animation-delay: -10s;
        }

        @keyframes orb-drift {
            to {
                transform: translate(28px, 18px) scale(1.07);
            }
        }

        .grid-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            will-change: auto;
            background-image:
                linear-gradient(rgba(13, 148, 136, .035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(13, 148, 136, .035) 1px, transparent 1px);
            background-size: 56px 56px;
            mask-image: radial-gradient(ellipse 80% 55% at 50% 0%, black 35%, transparent 100%);
        }

        /* ── NAV ─────────────────────────────────────────────────────── */
        nav#mainNav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            height: var(--nav-h);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            background: rgba(3, 11, 9, .88);
            border-bottom: 1px solid rgba(20, 184, 166, .1);
            backdrop-filter: blur(32px) saturate(180%);
            -webkit-backdrop-filter: blur(32px) saturate(180%);
            transition: background .3s, box-shadow .3s;
            will-change: transform;
            transform: translateZ(0);
        }

        nav#mainNav.scrolled {
            background: rgba(3, 11, 9, .97);
            box-shadow: 0 1px 0 rgba(20, 184, 166, .1), 0 6px 40px rgba(0, 0, 0, .5);
        }

        /* Brand */
        .nav-brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            text-decoration: none;
            color: inherit;
            flex-shrink: 0;
            min-width: 0;
        }

        .nav-logo {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1.5px solid rgba(20, 184, 166, .35);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(13, 148, 136, .1);
            box-shadow: 0 0 18px rgba(13, 148, 136, .2), inset 0 1px 0 rgba(94, 234, 212, .1);
        }

        .nav-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
        }

        .nav-logo-fallback {
            font-size: .68rem;
            font-weight: 800;
            color: var(--teal-xl);
            font-family: var(--font-display);
        }

        .nav-brand-text {
            min-width: 0;
        }

        .nav-name {
            font-size: .78rem;
            font-weight: 900;
            letter-spacing: .05em;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-family: var(--font-display);
            max-width: 260px;
            color: #fff;
        }

        .nav-sub {
            font-size: .58rem;
            font-weight: 700;
            color: var(--gold-l);
            margin-top: 1px;
            letter-spacing: .04em;
            white-space: nowrap;
            text-transform: uppercase;
        }

        /* Centre links */
        .nav-links {
            display: flex;
            gap: .05rem;
            list-style: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(234, 245, 242, .55);
            font-size: .77rem;
            font-weight: 600;
            padding: .4rem .82rem;
            border-radius: 8px;
            transition: color .2s, background .2s;
            white-space: nowrap;
            letter-spacing: .01em;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #fff;
            background: rgba(20, 184, 166, .1);
        }

        .nav-links a.nav-tamu {
            color: var(--gold-l);
        }

        .nav-links a.nav-tamu:hover,
        .nav-links a.nav-tamu.active {
            color: var(--gold-l);
            background: rgba(212, 168, 67, .1);
        }

        /* Right */
        .nav-right {
            display: flex;
            align-items: center;
            gap: .45rem;
            flex-shrink: 0;
        }

        .n-btn {
            height: 34px;
            padding: 0 .9rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--card2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .76rem;
            color: inherit;
            transition: border-color .2s, color .2s, background .2s;
            white-space: nowrap;
            font-weight: 600;
            font-family: var(--font-body);
            text-decoration: none;
            letter-spacing: .01em;
        }

        .n-btn:hover {
            border-color: var(--teal);
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .09);
        }

        .n-btn-primary {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 0 18px rgba(220, 38, 38, .25);
            font-weight: 800;
            font-size: .75rem;
            letter-spacing: .02em;
        }

        .n-btn-primary:hover {
            color: #fff;
            box-shadow: 0 4px 24px rgba(220, 38, 38, .4);
        }

        .n-btn-primary.state-open {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            box-shadow: 0 0 18px rgba(13, 148, 136, .25);
        }

        .n-btn-primary.state-open:hover {
            box-shadow: 0 4px 24px rgba(13, 148, 136, .42);
        }

        /* Hamburger */
        #menuBtn {
            width: 34px;
            height: 34px;
            flex-direction: column;
            gap: 5px;
            display: none;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            padding: 0;
            align-items: center;
            justify-content: center;
            transition: border-color .2s, background .2s;
        }

        #menuBtn:hover {
            border-color: var(--teal);
            background: rgba(20, 184, 166, .09);
        }

        #menuBtn span {
            display: block;
            width: 15px;
            height: 1.5px;
            background: currentColor;
            border-radius: 2px;
            transition: all .28s cubic-bezier(.4, 0, .2, 1);
        }

        #menuBtn.open span:nth-child(1) {
            transform: translateY(6.5px) rotate(45deg);
        }

        #menuBtn.open span:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }

        #menuBtn.open span:nth-child(3) {
            transform: translateY(-6.5px) rotate(-45deg);
        }

        /* ── DRAWER ──────────────────────────────────────────────────── */
        .drawer {
            position: fixed;
            top: var(--nav-h);
            left: 0;
            right: 0;
            z-index: 190;
            display: flex;
            flex-direction: column;
            gap: .25rem;
            background: rgba(3, 11, 9, .99);
            border-bottom: 1px solid transparent;
            max-height: 0;
            overflow: hidden;
            transition: max-height .32s cubic-bezier(.4, 0, .2, 1), padding .28s, border-color .28s;
            padding: 0 1.25rem;
        }

        .drawer.open {
            max-height: 420px;
            padding: .75rem 1.25rem 1.5rem;
            border-color: var(--border);
        }

        .drawer a {
            text-decoration: none;
            color: var(--muted);
            font-size: .84rem;
            font-weight: 600;
            padding: .6rem .85rem;
            border-radius: 9px;
            transition: color .2s, background .2s;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .drawer a:hover {
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .07);
        }

        .drawer a.active {
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .06);
        }

        .drawer a.drawer-tamu {
            color: var(--gold-l);
        }

        .drawer a.drawer-tamu:hover {
            color: var(--gold-l);
            background: rgba(212, 168, 67, .08);
        }

        .drawer-divider {
            height: 1px;
            background: var(--border2);
            margin: .35rem 0;
        }

        /* ── PAGE ────────────────────────────────────────────────────── */
        .page-wrap {
            position: relative;
            z-index: 1;
            padding-top: var(--nav-h);
            isolation: isolate;
        }

        .content-wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        /* ── FLASH ───────────────────────────────────────────────────── */
        .flash-area {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .flash-msg {
            margin-top: .85rem;
        }

        .flash-inner {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .7rem;
            padding: .8rem 1rem;
            border-radius: 11px;
            font-size: .8rem;
            font-weight: 500;
            opacity: 0;
            transform: translateY(4px);
            transition: opacity .3s, transform .3s;
        }

        .flash-inner button {
            opacity: .45;
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            font-size: 1rem;
            line-height: 1;
            flex-shrink: 0;
            padding: 0;
            transition: opacity .2s;
        }

        .flash-inner button:hover {
            opacity: 1;
        }

        .flash-success {
            background: rgba(20, 184, 166, .09);
            border: 1px solid rgba(20, 184, 166, .22);
            color: var(--teal-xl);
        }

        .flash-error {
            background: rgba(220, 38, 38, .08);
            border: 1px solid rgba(220, 38, 38, .2);
            color: #f87171;
        }

        .flash-warning {
            background: rgba(245, 158, 11, .08);
            border: 1px solid rgba(245, 158, 11, .2);
            color: #fbbf24;
        }

        .flash-info {
            background: rgba(96, 165, 250, .08);
            border: 1px solid rgba(96, 165, 250, .2);
            color: #93c5fd;
        }

        /* ── COMPONENTS ─────────────────────────────────────────────── */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: border-color .3s, transform .3s, box-shadow .3s;
        }

        .card-hover:hover {
            border-color: rgba(20, 184, 166, .3);
            transform: translateY(-3px);
            box-shadow: 0 10px 36px rgba(13, 148, 136, .12);
        }

        .badge {
            display: inline-block;
            padding: .2rem .75rem;
            border-radius: 999px;
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .28rem .85rem;
            border-radius: 999px;
            font-size: .66rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            background: rgba(20, 184, 166, .09);
            color: var(--teal-xl);
            border: 1px solid rgba(20, 184, 166, .22);
            margin-bottom: .8rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .65rem 1.5rem;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: box-shadow .22s, transform .22s;
            white-space: nowrap;
            letter-spacing: -.005em;
            font-family: var(--font-body);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            box-shadow: 0 0 24px rgba(13, 148, 136, .24);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 32px rgba(13, 148, 136, .4);
        }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border2);
        }

        .btn-ghost:hover {
            color: var(--teal-xl);
            border-color: rgba(20, 184, 166, .4);
            background: rgba(20, 184, 166, .06);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #b8882a);
            color: #fff;
            box-shadow: 0 0 20px rgba(212, 168, 67, .2);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 28px rgba(212, 168, 67, .34);
        }

        /* ── FORM ────────────────────────────────────────────────────── */
        .field {
            display: flex;
            flex-direction: column;
            gap: .4rem;
        }

        .field label {
            font-size: .76rem;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: .01em;
        }

        .input {
            width: 100%;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: .62rem .95rem;
            font-size: .86rem;
            font-family: var(--font-body);
            color: var(--text);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .input::placeholder {
            color: var(--muted2);
        }

        .input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1);
        }

        .input-error {
            border-color: rgba(220, 38, 38, .4);
        }

        .error-msg {
            font-size: .72rem;
            color: #f87171;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        /* ── TABLE ───────────────────────────────────────────────────── */
        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl thead th {
            padding: .8rem 1rem;
            font-size: .66rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .tbl tbody tr {
            border-bottom: 1px solid var(--border2);
            transition: background .15s;
        }

        .tbl tbody tr:hover {
            background: rgba(13, 148, 136, .035);
        }

        .tbl tbody td {
            padding: .8rem 1rem;
            font-size: .83rem;
        }

        .tbl tbody tr:last-child {
            border-bottom: none;
        }

        /* ── REVEAL ──────────────────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .5s ease, transform .5s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
        }

        .reveal-delay-1 {
            transition-delay: .1s;
        }

        .reveal-delay-2 {
            transition-delay: .18s;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border2);
            margin: 1.25rem 0;
        }

        /* ── FOOTER ──────────────────────────────────────────────────── */
        footer.site-footer {
            border-top: 1px solid var(--border);
            padding: 1.75rem 2rem;
            text-align: center;
            font-size: .7rem;
            color: var(--muted2);
            position: relative;
            z-index: 1;
            letter-spacing: .01em;
        }

        /* ── PERSON MODAL ────────────────────────────────────────────── */
        .person-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 500;
            background: rgba(4, 10, 9, .78);
            backdrop-filter: blur(14px) saturate(140%);
            -webkit-backdrop-filter: blur(14px) saturate(140%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }

        .person-modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .person-modal {
            background: linear-gradient(145deg, #0c1a18, #091410);
            border: 1px solid rgba(20, 184, 166, .18);
            border-radius: 22px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .55), 0 0 0 1px rgba(20, 184, 166, .07), inset 0 1px 0 rgba(94, 234, 212, .06);
            width: 100%;
            max-width: 400px;
            transform: translateY(22px) scale(.97);
            transition: transform .28s cubic-bezier(.22, 1, .36, 1), opacity .25s ease;
            overflow: hidden;
            position: relative;
        }

        .person-modal-overlay.open .person-modal {
            transform: translateY(0) scale(1);
        }

        .modal-close {
            position: absolute;
            top: .85rem;
            right: .85rem;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            color: var(--muted);
            cursor: pointer;
            font-size: .85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s, border-color .2s, color .2s;
            line-height: 1;
            padding: 0;
            font-family: var(--font-body);
            z-index: 2;
        }

        .modal-close:hover {
            background: rgba(220, 38, 38, .15);
            border-color: rgba(220, 38, 38, .3);
            color: #f87171;
        }

        .modal-header-strip {
            height: 3px;
            background: linear-gradient(90deg, var(--teal), var(--gold-l), var(--teal-xl));
        }

        .modal-avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1.5rem 1.25rem;
            gap: .75rem;
        }

        .modal-avatar-ring {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), var(--gold));
            padding: 2px;
            flex-shrink: 0;
        }

        .modal-avatar-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-avatar-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-avatar-fallback {
            font-size: 2rem;
            font-weight: 800;
            font-family: var(--font-display);
            color: var(--teal-xl);
        }

        .modal-name {
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: -.025em;
            font-family: var(--font-display);
            text-align: center;
            line-height: 1.25;
        }

        .modal-role-badge {
            display: inline-flex;
            align-items: center;
            padding: .28rem .85rem;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .06em;
            background: rgba(20, 184, 166, .1);
            border: 1px solid rgba(20, 184, 166, .2);
            color: var(--teal-xl);
        }

        .modal-role-badge.gold {
            background: rgba(212, 168, 67, .1);
            border-color: rgba(212, 168, 67, .2);
            color: var(--gold-l);
        }

        .modal-body {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }

        .modal-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: .55rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
        }

        .modal-row:last-child {
            border-bottom: none;
        }

        .modal-row-label {
            font-size: .7rem;
            color: var(--muted);
            font-weight: 500;
            flex-shrink: 0;
        }

        .modal-row-val {
            font-size: .82rem;
            font-weight: 600;
            text-align: right;
            word-break: break-all;
        }

        .modal-row-mono {
            font-family: monospace;
            font-size: .8rem;
            color: var(--teal-xl);
        }

        .modal-quote {
            margin: .25rem 0 .5rem;
            padding: .75rem 1rem;
            border-left: 2px solid rgba(20, 184, 166, .3);
            font-size: .78rem;
            font-style: italic;
            color: var(--muted);
            line-height: 1.65;
            border-radius: 0 8px 8px 0;
            background: rgba(20, 184, 166, .03);
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border2);
            display: flex;
            gap: .5rem;
        }

        .modal-footer .btn {
            flex: 1;
            justify-content: center;
            font-size: .78rem;
            padding: .58rem;
        }

        .person-card.clickable {
            cursor: pointer;
        }

        /* ── RESPONSIVE ──────────────────────────────────────────────── */
        @media (max-width: 960px) {
            .nav-links {
                display: none !important;
            }

            #menuBtn {
                display: flex !important;
            }
        }

        @media (max-width: 768px) {
            :root {
                --nav-h: 54px;
            }

            /* Nav: kurangi blur, perkuat background */
            nav#mainNav {
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                background: rgba(3, 11, 9, .96);
            }

            nav#mainNav.scrolled {
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                background: rgba(3, 11, 9, .99);
            }

            /* Sembunyikan tombol nav di HP */
            .n-btn-primary.nav-home-btn {
                display: none !important;
            }

            /* Orb: sembunyikan — penyebab utama lag GPU */
            .orb {
                display: none !important;
            }

            /* Grid-bg: hapus mask mahal, perbesar tile */
            .grid-bg {
                mask-image: none;
                -webkit-mask-image: none;
                background-size: 72px 72px;
                opacity: .22;
            }

            /* Card: matikan backdrop-filter */
            .card,
            .hero-card,
            .search-card,
            .cd-card,
            .person-modal,
            .drawer {
                backdrop-filter: none !important;
                -webkit-backdrop-filter: none !important;
            }

            .card {
                background: rgba(20, 184, 166, .08);
            }

            .hero-card {
                background: rgba(10, 22, 20, .95);
            }

            .drawer {
                background: rgba(3, 11, 9, .99);
            }

            /* Reveal: langsung visible, skip animasi masuk */
            .reveal {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }

            /* Potong semua animasi masuk */
            .hero-eyebrow,
            .hero-title,
            .hero-desc,
            .hero-meta,
            .hero-stats,
            .hero-card,
            .stat-tile,
            .search-card,
            .cd-card {
                animation-duration: .12s !important;
                animation-delay: 0s !important;
            }

            /* Layout */
            .content-wrap {
                padding: 1.75rem .65rem;
            }

            .nav-name {
                max-width: none;
                overflow: visible;
                text-overflow: unset;
                white-space: normal;
                line-height: 1.2;
                font-size: .72rem;
            }

            .people-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: .65rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: .75rem;
            }

            .search-form {
                width: 100%;
            }

            .search-field-wrap {
                flex: 1;
            }

            .search-field-input {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .tamu-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .tamu-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .doc-wrap {
                padding: 0 .25rem;
            }

            .doc-card .doc-body {
                padding: 1.1rem 1.2rem 1.5rem;
            }

            .kop-surat {
                padding: 1.25rem 1.2rem 1rem;
                gap: .65rem;
            }

            .kop-surat img {
                height: 52px;
                width: 52px;
            }

            .hasil-wrap {
                max-width: 100%;
            }

            .result-header,
            .result-info,
            .result-actions {
                padding-left: 1.1rem;
                padding-right: 1.1rem;
            }

            .tamu-table-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .tamu-tbl {
                min-width: 500px;
            }

            /* Modal overlay: kurangi blur */
            .person-modal-overlay {
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
            }
        }

        @media (max-width: 599px) {

            .search-card,
            .cd-card,
            .state-card,
            .hasil-wrap,
            .konfirmasi-wrap,
            .scan-wrap {
                max-width: 100% !important;
                border-radius: 14px;
            }

            .hero-section {
                padding: 3rem .5rem;
            }
        }

        @media (max-width: 540px) {
            :root {
                --nav-h: 50px;
            }

            .content-wrap {
                padding: 1.5rem .5rem;
            }

            .nav-sub {
                display: none;
            }

            .nav-name {
                font-size: .68rem;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .search-card {
                padding: 1.25rem 1rem;
            }

            .konfirmasi-wrap {
                max-width: 100%;
            }

            .scan-wrap {
                max-width: 100%;
            }

            .doc-toolbar {
                flex-direction: column;
                align-items: flex-start;
                gap: .5rem;
            }

            .person-modal {
                max-width: 100%;
                border-radius: 18px 18px 0 0;
            }

            .person-modal-overlay {
                align-items: flex-end;
                padding: 0;
            }
        }

        /* ── HOVER: disable transform di touchscreen ─────────────────── */
        @media (hover: none) {

            .card-hover:hover,
            .card-hover:active {
                transform: none !important;
                box-shadow: none !important;
            }

            .btn:hover,
            .btn-primary:hover,
            .n-btn:hover,
            .n-btn-primary:hover {
                transform: none !important;
            }
        }

        /* ── REDUCED MOTION ──────────────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }

            .wa-fab::before {
                animation: none !important;
            }
        }

        /* ── PRINT ───────────────────────────────────────────────────── */
        @media print {

            .orb,
            .grid-bg,
            nav#mainNav,
            .drawer,
            .flash-area,
            footer.site-footer,
            .wa-fab {
                display: none !important;
            }

            .page-wrap {
                padding-top: 0;
            }

            .content-wrap {
                padding: 0;
                max-width: 100%;
            }

            body {
                background: #fff;
                color: #000;
            }
        }
    </style>

    {{-- ── PWA & Icons ─────────────────────────────────────── --}}
    <meta name="theme-color" content="#0d9488">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $instansi?->nama ?? 'SKL' }}">
    <meta name="application-name" content="{{ $instansi?->nama ?? 'SKL' }}">

    {{-- Favicon set --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icons/icon-192.png" type="image/png">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <link rel="manifest" href="/manifest.json">

    {{-- ── Fonts ───────────────────────────────────────────── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,400&display=swap"
        rel="stylesheet">

    {{-- ── Vite assets ─────────────────────────────────────── --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="grid-bg"></div>

    @php
        $navTp = $tahunPelajaran ?? null;
        $tampilTamu = $navTp && $navTp->isKelulusanAktif();
    @endphp

    {{-- ── NAVBAR ───────────────────────────────────────────────── --}}
    <nav id="mainNav">
        <a href="{{ route('landing') }}" class="nav-brand">
            <div class="nav-logo">
                <img src="/favicon.ico" alt="Logo"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <span class="nav-logo-fallback" style="display:none;">SKL</span>
            </div>
            <div class="nav-brand-text">
                <div class="nav-name">{{ $instansi?->nama ?? config('app.name') }}</div>
                <div class="nav-sub">Layanan Kelulusan Digital</div>
            </div>
        </a>

        {{-- Center links (hidden ≤960px) --}}
        <ul class="nav-links">
            <li>
                <a href="{{ route('personil.index') }}" class="{{ request()->routeIs('personil*') ? 'active' : '' }}">
                    Personil
                </a>
            </li>
            <li>
                <a href="{{ route('alumni.index') }}" class="{{ request()->routeIs('alumni*') ? 'active' : '' }}">
                    Alumni
                </a>
            </li>
            @if ($tampilTamu)
                <li>
                    <a href="{{ route('tamu.index') }}"
                        class="nav-tamu {{ request()->routeIs('tamu*') ? 'active' : '' }}">
                        Tamu Undangan
                    </a>
                </li>
            @endif
        </ul>

        <div class="nav-right">
            {{-- Hamburger --}}
            <button id="menuBtn" aria-label="Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            @php
                $navNow = now();
                $navBuka =
                    $navTp && $navNow->between($navTp->jadwal_pengumuman_mulai, $navTp->jadwal_pengumuman_selesai);
                $navLabel = $navBuka
                    ? 'Cek Kelulusan'
                    : ($navTp && $navNow->lt($navTp->jadwal_pengumuman_mulai)
                        ? 'Belum Dibuka'
                        : 'Pengumuman Ditutup');
            @endphp
            <a href="{{ route('landing') }}"
                class="n-btn n-btn-primary nav-home-btn {{ $navBuka ? 'state-open' : '' }}">
                {{ request()->routeIs('landing') ? 'Beranda' : $navLabel }}
            </a>
        </div>
    </nav>

    {{-- ── MOBILE DRAWER ───────────────────────────────────────── --}}
    <div class="drawer" id="drawer" aria-hidden="true">
        <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'active' : '' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            Beranda
        </a>
        <div class="drawer-divider"></div>
        <a href="{{ route('personil.index') }}" class="{{ request()->routeIs('personil*') ? 'active' : '' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            Personil
        </a>
        <a href="{{ route('alumni.index') }}" class="{{ request()->routeIs('alumni*') ? 'active' : '' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                <path d="M6 12v5c3 3 9 3 12 0v-5" />
            </svg>
            Alumni
        </a>
        @if ($tampilTamu)
            <div class="drawer-divider"></div>
            <a href="{{ route('tamu.index') }}"
                class="drawer-tamu {{ request()->routeIs('tamu*') ? 'active' : '' }}">
                Tamu Undangan
            </a>
        @endif
    </div>

    {{-- ── PERSON MODAL ─────────────────────────────────────────── --}}
    <div class="person-modal-overlay" id="personModal" role="dialog" aria-modal="true"
        aria-labelledby="modalName">
        <div class="person-modal" id="personModalBox">
            <div class="modal-header-strip"></div>
            <button class="modal-close" id="modalClose" aria-label="Tutup">&times;</button>

            <div class="modal-avatar-section">
                <div class="modal-avatar-ring">
                    <div class="modal-avatar-inner" id="modalAvatarInner">
                        <span class="modal-avatar-fallback" id="modalAvatarFallback">?</span>
                    </div>
                </div>
                <div class="modal-name" id="modalName">—</div>
                <div class="modal-role-badge" id="modalBadge">—</div>
            </div>

            <div class="modal-body" id="modalBody"></div>

            <div class="modal-footer" id="modalFooter" style="display:none;"></div>
        </div>
    </div>

    {{-- ── PAGE ─────────────────────────────────────────────────── --}}
    <div class="page-wrap">
        <div class="flash-area">
            @foreach (['success', 'error', 'warning', 'info'] as $type)
                @if (session($type))
                    <div class="flash-msg" data-type="{{ $type }}">
                        <div class="flash-inner flash-{{ $type }}">
                            <span>{{ session($type) }}</span>
                            <button onclick="this.closest('.flash-msg').remove()" aria-label="Tutup">&times;</button>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <main class="content-wrap">@yield('content')</main>

        <footer class="site-footer">
            &copy; {{ date('Y') }} {{ $instansi?->nama ?? config('app.name') }}
            &nbsp;&middot;&nbsp; Layanan Kelulusan Digital
        </footer>
    </div>

    <script>
        (() => {
            /* ── Nav scroll ─────────────────────────────── */
            const nav = document.getElementById('mainNav');
            window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 40), {
                passive: true
            });

            /* ── Drawer toggle ──────────────────────────── */
            const menuBtn = document.getElementById('menuBtn');
            const drawer = document.getElementById('drawer');

            function toggleDrawer(force) {
                const open = typeof force === 'boolean' ? force : !drawer.classList.contains('open');
                drawer.classList.toggle('open', open);
                menuBtn.classList.toggle('open', open);
                menuBtn.setAttribute('aria-expanded', open);
                drawer.setAttribute('aria-hidden', !open);
            }

            menuBtn.addEventListener('click', e => {
                e.stopPropagation();
                toggleDrawer();
            });
            [...drawer.querySelectorAll('a')].forEach(a => a.addEventListener('click', () => toggleDrawer(false)));
            document.addEventListener('click', e => {
                if (!drawer.contains(e.target) && !menuBtn.contains(e.target)) toggleDrawer(false);
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') toggleDrawer(false);
            });

            /* ── Flash messages ─────────────────────────── */
            document.querySelectorAll('.flash-msg .flash-inner').forEach(el => {
                requestAnimationFrame(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'none';
                });
                setTimeout(() => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-4px)';
                    setTimeout(() => el.closest('.flash-msg')?.remove(), 300);
                }, 4200);
            });

            /* ── Reveal on scroll ───────────────────────── */
            const revealObs = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        revealObs.unobserve(e.target);
                    }
                });
            }, {
                threshold: .1,
                rootMargin: '0px 0px -36px 0px'
            });
            document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

            /* ── Person Modal ───────────────────────────── */
            const overlay = document.getElementById('personModal');
            const modalBox = document.getElementById('personModalBox');
            const modalClose = document.getElementById('modalClose');

            function openPersonModal(data) {
                /* Avatar */
                const inner = document.getElementById('modalAvatarInner');
                const fb = document.getElementById('modalAvatarFallback');
                inner.innerHTML = '';
                if (data.photo) {
                    const img = document.createElement('img');
                    img.src = data.photo;
                    img.alt = data.nama;
                    inner.appendChild(img);
                } else {
                    fb.textContent = (data.nama || '?').trim().charAt(0).toUpperCase();
                    inner.appendChild(fb);
                }

                /* Name & badge */
                document.getElementById('modalName').textContent = data.nama || '—';
                const badge = document.getElementById('modalBadge');
                badge.textContent = data.badge || '—';
                badge.className = 'modal-role-badge' + (data.badgeGold ? ' gold' : '');

                /* Body rows */
                const body = document.getElementById('modalBody');
                body.innerHTML = '';

                if (data.quote) {
                    const q = document.createElement('blockquote');
                    q.className = 'modal-quote';
                    q.textContent = '\u201C' + data.quote + '\u201D';
                    body.appendChild(q);
                }

                (data.rows || []).forEach(([label, val, mono]) => {
                    if (!val) return;
                    const row = document.createElement('div');
                    row.className = 'modal-row';
                    const lbl = document.createElement('span');
                    lbl.className = 'modal-row-label';
                    lbl.textContent = label;
                    const valEl = document.createElement('span');
                    valEl.className = 'modal-row-val' + (mono ? ' modal-row-mono' : '');
                    valEl.textContent = val;
                    row.appendChild(lbl);
                    row.appendChild(valEl);
                    body.appendChild(row);
                });

                /* Footer / social */
                const footer = document.getElementById('modalFooter');
                footer.innerHTML = '';
                if (data.sosial) {
                    footer.style.display = 'flex';
                    const a = document.createElement('a');
                    a.href = data.sosial;
                    a.target = '_blank';
                    a.rel = 'noopener';
                    a.className = 'btn btn-ghost';
                    a.textContent = '🔗 Sosial Media';
                    footer.appendChild(a);
                } else {
                    footer.style.display = 'none';
                }

                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
                setTimeout(() => modalClose.focus(), 50);
            }

            function closeModal() {
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }

            modalClose.addEventListener('click', closeModal);
            overlay.addEventListener('click', e => {
                if (e.target === overlay) closeModal();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
            });

            /* Attach to all person cards */
            function bindPersonCards() {
                document.querySelectorAll('.person-card[data-person]').forEach(card => {
                    if (card._modalBound) return;
                    card._modalBound = true;
                    card.classList.add('clickable');
                    card.setAttribute('role', 'button');
                    card.setAttribute('tabindex', '0');
                    card.addEventListener('click', () => openPersonModal(JSON.parse(card.dataset.person)));
                    card.addEventListener('keydown', e => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            openPersonModal(JSON.parse(card.dataset.person));
                        }
                    });
                });
            }
            bindPersonCards();

            /* Re-bind after any dynamic DOM mutation (pagination) */
            new MutationObserver(bindPersonCards).observe(document.body, {
                childList: true,
                subtree: true
            });

            /* Expose globally */
            window.openPersonModal = openPersonModal;
        })();
    </script>

    {{-- ── WHATSAPP FLOATING BUTTON ─────────────────────────────── --}}
    @php $waNumber = $instansi?->whatsapp ?? '62895351856267'; @endphp
    <a href="https://wa.me/{{ preg_replace('/\D/', '', $waNumber) }}" target="_blank" rel="noopener" class="wa-fab"
        aria-label="Hubungi via WhatsApp">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
            <path
                d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.855L.057 23.885a.5.5 0 0 0 .606.61l6.207-1.63A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.876 9.876 0 0 1-5.031-1.378l-.36-.214-3.733.981.996-3.648-.235-.374A9.844 9.844 0 0 1 2.118 12C2.118 6.54 6.54 2.118 12 2.118S21.882 6.54 21.882 12 17.46 21.882 12 21.882z" />
        </svg>
    </a>

    <style>
        .wa-fab {
            position: fixed;
            bottom: 1.6rem;
            right: 1.6rem;
            z-index: 300;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #25d366;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 24px rgba(37, 211, 102, .4), 0 1px 6px rgba(0, 0, 0, .25);
            transition: transform .22s, box-shadow .22s;
            text-decoration: none;
        }

        .wa-fab:hover {
            transform: translateY(-3px) scale(1.07);
            box-shadow: 0 8px 32px rgba(37, 211, 102, .55), 0 2px 8px rgba(0, 0, 0, .2);
        }

        .wa-fab:active {
            transform: scale(.95);
        }

        /* Pulse ring */
        .wa-fab::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: #25d366;
            animation: wa-pulse 2.4s ease-out infinite;
            z-index: -1;
        }

        @keyframes wa-pulse {
            0% {
                transform: scale(1);
                opacity: .55;
            }

            70% {
                transform: scale(1.65);
                opacity: 0;
            }

            100% {
                transform: scale(1.65);
                opacity: 0;
            }
        }

        @media (max-width: 540px) {
            .wa-fab {
                bottom: 1.1rem;
                right: 1.1rem;
                width: 48px;
                height: 48px;
            }
        }
    </style>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', async () => {
                try {
                    const reg = await navigator.serviceWorker.register('/sw.js', {
                        scope: '/'
                    });

                    // Deteksi update SW → minta user reload
                    reg.addEventListener('updatefound', () => {
                        const w = reg.installing;
                        w.addEventListener('statechange', () => {
                            if (w.state === 'installed' && navigator.serviceWorker.controller) {
                                // Kirim SKIP_WAITING agar langsung aktif
                                w.postMessage({
                                    type: 'SKIP_WAITING'
                                });
                                // Reload halaman setelah SW baru aktif
                                navigator.serviceWorker.addEventListener('controllerchange',
                                    () => location.reload());
                            }
                        });
                    });
                } catch (e) {
                    console.warn('[SW] Gagal registrasi:', e);
                }
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
