<style>
    .page-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem
    }

    .page-title {
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.03em;
        font-family: var(--font-display)
    }

    .page-meta {
        font-size: .76rem;
        color: var(--muted);
        margin-top: .25rem
    }

    .page-meta strong {
        color: var(--text)
    }

    .search-form {
        display: flex;
        gap: .45rem;
        align-items: center
    }

    .search-field-wrap {
        position: relative
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
        color: var(--muted2)
    }

    .search-field-input:focus {
        border-color: rgba(20, 184, 166, .42);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, .1)
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
        box-shadow: 0 3px 18px rgba(13, 148, 136, .32)
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
        color: var(--teal-xl)
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem
    }

    .empty-title {
        font-size: .86rem;
        color: var(--muted);
        margin-bottom: .65rem
    }

    .empty-link {
        font-size: .76rem;
        color: var(--teal-xl);
        text-decoration: none
    }

    .empty-link:hover {
        text-decoration: underline
    }

    .people-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(172px, 1fr));
        gap: .9rem
    }

    .person-card {
        padding: 1.4rem .9rem;
        text-align: center;
        border-radius: var(--radius);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .12rem
    }

    .avatar-wrap {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: .7rem;
        flex-shrink: 0
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 1.5px solid var(--border)
    }

    .avatar-fallback {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.2rem;
        font-family: var(--font-display);
        border: 1.5px solid var(--border);
        background: rgba(20, 184, 166, .08);
        color: var(--teal-xl);
    }

    .person-name {
        font-size: .85rem;
        font-weight: 700;
        line-height: 1.25;
        font-family: var(--font-display)
    }

    .person-sub {
        font-size: .71rem;
        color: var(--muted);
        margin-top: .12rem
    }

    .person-mono {
        font-size: .67rem;
        font-family: monospace;
        color: var(--muted2);
        margin-top: .08rem;
        letter-spacing: .03em
    }

    .person-quote {
        font-size: .7rem;
        color: var(--muted);
        font-style: italic;
        margin-top: .45rem;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden
    }

    .person-link {
        font-size: .7rem;
        color: var(--teal-xl);
        text-decoration: none;
        margin-top: .35rem;
        display: inline-block;
        border-bottom: 1px solid rgba(94, 234, 212, .25);
        padding-bottom: 1px;
        transition: border-color .2s
    }

    .person-link:hover {
        border-color: var(--teal-xl)
    }

    .pagination-wrap {
        margin-top: 1.75rem
    }
</style>
