<style>
    /* ── Page Header ──────────────────────────────────────────── */
    .page-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.03em;
        font-family: var(--font-display);
    }

    .page-meta {
        font-size: .76rem;
        color: var(--muted);
        margin-top: .25rem;
    }

    .page-meta strong {
        color: var(--text);
    }

    /* ── Search Form ──────────────────────────────────────────── */
    .search-form {
        display: flex;
        gap: .45rem;
        align-items: center;
    }

    .search-field-wrap {
        position: relative;
    }

    .search-field-input {
        background: var(--card2);
        border: 1px solid var(--border);
        border-radius: 9px;
        padding: .52rem .9rem;
        font-size: .8rem;
        font-family: var(--font-body);
        color: var(--text);
        width: 14rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .search-field-input::placeholder {
        color: var(--muted2);
    }

    .search-field-input:focus {
        border-color: rgba(20, 184, 166, .42);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, .1);
    }

    .search-btn {
        background: linear-gradient(135deg, var(--teal), var(--teal-d));
        color: #fff;
        border: none;
        border-radius: 9px;
        padding: .52rem 1rem;
        font-size: .8rem;
        font-weight: 700;
        font-family: var(--font-body);
        cursor: pointer;
        transition: all .2s;
        box-shadow: 0 0 14px rgba(13, 148, 136, .18);
    }

    .search-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 18px rgba(13, 148, 136, .32);
    }

    .clear-btn {
        background: var(--card2);
        border: 1px solid var(--border);
        border-radius: 9px;
        padding: .52rem .65rem;
        font-size: .8rem;
        color: var(--muted);
        cursor: pointer;
        font-family: var(--font-body);
        transition: all .2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        line-height: 1;
    }

    .clear-btn:hover {
        border-color: rgba(20, 184, 166, .32);
        color: var(--teal-xl);
    }

    /* ── Empty State ──────────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-title {
        font-size: .86rem;
        color: var(--muted);
        margin-bottom: .65rem;
    }

    .empty-link {
        font-size: .76rem;
        color: var(--teal-xl);
        text-decoration: none;
    }

    .empty-link:hover {
        text-decoration: underline;
    }

    /* ── People Grid ──────────────────────────────────────────── */
    .people-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(160px, 100%), 1fr));
        gap: 1rem;
    }

    /* ── Person Card ──────────────────────────────────────────── */
    .person-card {
        padding: clamp(.85rem, 3vw, 1.4rem) clamp(.65rem, 2.5vw, .9rem) clamp(.75rem, 2.5vw, 1rem);
        text-align: center;
        border-radius: var(--radius);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .12rem;
        position: relative;
        overflow: hidden;
    }

    /* Subtle teal glow on hover */
    .person-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: radial-gradient(ellipse at 50% 0%, rgba(20, 184, 166, .08), transparent 70%);
        opacity: 0;
        transition: opacity .3s;
        pointer-events: none;
    }

    .person-card:hover::before {
        opacity: 1;
    }

    /* Avatar — ukuran fluid berdasarkan lebar container */
    .avatar-wrap {
        width: clamp(48px, 12vw, 68px);
        height: clamp(48px, 12vw, 68px);
        border-radius: 50%;
        margin-bottom: clamp(.5rem, 1.5vw, .8rem);
        flex-shrink: 0;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 1.5px solid var(--border);
    }

    .avatar-fallback {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: clamp(.9rem, 3vw, 1.25rem);
        font-family: var(--font-display);
        border: 1.5px solid var(--border);
        background: rgba(20, 184, 166, .08);
        color: var(--teal-xl);
    }

    .person-name {
        font-size: clamp(.75rem, 2.2vw, .88rem);
        font-weight: 700;
        line-height: 1.25;
        font-family: var(--font-display);
    }

    .person-sub {
        font-size: clamp(.63rem, 1.8vw, .72rem);
        color: var(--muted);
        margin-top: .12rem;
    }

    .person-mono {
        font-size: clamp(.58rem, 1.6vw, .67rem);
        font-family: monospace;
        color: var(--muted2);
        margin-top: .08rem;
        letter-spacing: .03em;
    }

    .person-quote {
        font-size: clamp(.63rem, 1.7vw, .7rem);
        color: var(--muted);
        font-style: italic;
        margin-top: .45rem;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* "Lihat detail" hint */
    .person-hint {
        font-size: clamp(.55rem, 1.5vw, .62rem);
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--teal-xl);
        margin-top: .5rem;
        opacity: 0;
        transition: opacity .2s, transform .2s;
        transform: translateY(4px);
    }

    .person-card:hover .person-hint,
    .person-card:focus .person-hint {
        opacity: .8;
        transform: translateY(0);
    }

    /* Focus ring */
    .person-card:focus-visible {
        outline: 2px solid rgba(20, 184, 166, .55);
        outline-offset: 2px;
    }

    /* ── Responsive overrides ─────────────────────────────────── */

    /* Laptop / tablet lebar — 4–5 kolom nyaman */
    @media (min-width: 900px) {
        .people-grid {
            grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
            gap: 1.1rem;
        }
    }

    /* Tablet portrait — 3 kolom */
    @media (max-width: 899px) and (min-width: 600px) {
        .people-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: .85rem;
        }
    }

    /* Smartphone landscape / kecil — 2 kolom */
    @media (max-width: 599px) {
        .people-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: .65rem;
        }

        /* Card lebih compact di hp */
        .person-card {
            padding: .9rem .6rem .75rem;
        }

        .avatar-wrap {
            width: 52px;
            height: 52px;
            margin-bottom: .55rem;
        }

        .person-name {
            font-size: .78rem;
        }

        .person-sub {
            font-size: .65rem;
        }

        .person-mono {
            font-size: .6rem;
        }

        /* Hint selalu visible di touch (tidak ada hover) */
        .person-hint {
            opacity: .55;
            transform: none;
            font-size: .55rem;
        }
    }

    /* HP kecil ≤360px — tetap 2 kolom tapi lebih compact */
    @media (max-width: 360px) {
        .people-grid {
            gap: .5rem;
        }

        .person-card {
            padding: .8rem .5rem .65rem;
        }

        .avatar-wrap {
            width: 44px;
            height: 44px;
        }

        .person-name {
            font-size: .72rem;
        }
    }

    /* ── Pagination ───────────────────────────────────────────── */
    .pagination-wrap {
        margin-top: 1.75rem;
    }
</style>
