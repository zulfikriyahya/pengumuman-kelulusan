<style>
    .doc-wrap {
        max-width: 680px;
        margin: 0 auto
    }

    .doc-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        gap: .75rem;
        flex-wrap: wrap
    }

    .doc-back {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-size: .8rem;
        color: var(--muted);
        text-decoration: none;
        transition: color .2s
    }

    .doc-back:hover {
        color: var(--teal-xl)
    }

    .doc-back span {
        transition: transform .2s
    }

    .doc-back:hover span {
        transform: translateX(-2px)
    }

    .doc-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 24px rgba(0, 0, 0, .12);
        border: 1px solid rgba(0, 0, 0, .06);
        overflow: hidden;
        color: #1a1a1a
    }

    .kop-surat {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.75rem 2rem 1.25rem;
        border-bottom: 3px double #1a1a1a
    }

    .kop-surat img {
        height: 72px;
        width: 72px;
        object-fit: contain;
        flex-shrink: 0
    }

    .kop-text {
        flex: 1;
        text-align: center
    }

    .kop-text h1 {
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #111;
        font-family: 'Times New Roman', serif
    }

    .kop-text p {
        font-size: .7rem;
        color: #666;
        margin-top: .2rem
    }

    .doc-body {
        padding: 1.5rem 2rem 2rem;
        font-family: 'Times New Roman', Georgia, serif;
        font-size: .82rem;
        line-height: 1.75;
        color: #1a1a1a
    }

    .doc-title {
        text-align: center;
        font-size: .94rem;
        font-weight: 700;
        text-decoration: underline;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin: .5rem 0 1.25rem
    }

    .doc-meta {
        border-collapse: collapse;
        margin-bottom: 1rem;
        font-size: .8rem
    }

    .doc-meta td {
        padding: 2px 4px 2px 0;
        vertical-align: top
    }

    .doc-meta .lbl {
        width: 5rem;
        color: #666;
        white-space: nowrap
    }

    .doc-meta .sep {
        width: .5rem
    }

    .doc-data {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
        font-size: .8rem
    }

    .doc-data td {
        padding: 3px 4px 3px 0;
        vertical-align: top
    }

    .doc-data .lbl {
        width: 9rem;
        color: #666
    }

    .doc-data .sep {
        width: .5rem
    }

    .doc-data .val {
        font-weight: 600
    }

    .doc-para {
        text-indent: 2rem;
        margin-bottom: .75rem;
        text-align: justify
    }

    .ttd-block {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem
    }

    .ttd-inner {
        text-align: center;
        width: 11rem;
        font-size: .8rem
    }

    .ttd-inner img {
        height: 60px;
        margin: .5rem auto;
        display: block;
        object-fit: contain
    }

    .ttd-space {
        height: 60px
    }

    .ttd-nama {
        font-weight: 700;
        text-decoration: underline
    }

    .ttd-nip {
        font-size: .72rem;
        color: #555;
        margin-top: .15rem
    }

    .doc-note {
        text-align: center;
        font-size: .7rem;
        color: var(--muted2);
        margin-top: .85rem
    }

    .doc-jadwal {
        border-collapse: collapse;
        margin: .25rem 0 1rem 2rem;
        font-size: .8rem
    }

    .doc-jadwal td {
        padding: 3px 4px 3px 0;
        vertical-align: top
    }

    .doc-jadwal .lbl {
        width: 7rem;
        color: #666
    }

    .qr-block {
        margin-top: 1.25rem;
        padding-top: 1rem;
        border-top: 1px dashed #d1d5db;
        text-align: center
    }

    .qr-block img {
        width: 84px;
        height: 84px;
        object-fit: contain;
        margin: 0 auto
    }

    .qr-block p {
        font-size: .68rem;
        color: #9ca3af;
        margin-top: .3rem
    }

    .doc-alert {
        padding: .65rem .85rem;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 8px;
        color: #92400e;
        font-size: .75rem;
        margin: .5rem 0 1rem 2rem
    }
</style>
