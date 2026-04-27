<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Trait reusable untuk controller yang menampilkan daftar "orang"
 * dengan fitur pencarian (Alumni, Personil, dsb.)
 */
trait HasPeopleIndex
{
    /**
     * Nama model Eloquent (FQCN), diisi di masing-masing controller.
     * Contoh: protected string $model = Alumni::class;
     */
    abstract protected function model(): string;

    /**
     * Nama view untuk halaman index.
     * Contoh: 'alumni.index'
     */
    abstract protected function indexView(): string;

    /**
     * Kolom yang bisa dicari (OR query).
     * Contoh: ['nisn', 'nama']
     */
    abstract protected function searchColumns(): array;

    /**
     * Kolom default untuk ordering.
     */
    protected function orderBy(): string
    {
        return 'nama';
    }

    /**
     * Apakah hasil pakai paginate (true) atau get (false).
     */
    protected function paginated(): bool
    {
        return true;
    }

    protected function perPage(): int
    {
        return 12;
    }

    // ──────────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $items = $this->buildQuery()->orderBy($this->orderBy());

        $items = $this->paginated()
            ? $items->paginate($this->perPage())
            : $items->get();

        return view($this->indexView(), compact('items'));
    }

    public function search(Request $request): View
    {
        $keyword = $this->resolveKeyword($request);

        $items = $this->buildQuery($keyword)->orderBy($this->orderBy());

        $items = $this->paginated()
            ? $items->paginate($this->perPage())->withQueryString()
            : $items->get();

        return view($this->indexView(), compact('items', 'keyword'));
    }

    // ──────────────────────────────────────────────────────────────

    protected function buildQuery(?string $keyword = null): Builder
    {
        $query = $this->model()::query();

        if ($keyword) {
            $columns = $this->searchColumns();
            $query->where(function (Builder $q) use ($keyword, $columns) {
                foreach ($columns as $i => $col) {
                    $method = $i === 0 ? 'where' : 'orWhere';
                    // Kolom NISN/kode: exact match; kolom teks: LIKE
                    if (in_array($col, ['nisn', 'nip', 'id'])) {
                        $q->$method($col, $keyword);
                    } else {
                        $q->$method($col, 'like', "%{$keyword}%");
                    }
                }
            });
        }

        return $query;
    }

    /**
     * Ambil keyword dari request — subclass bisa override jika perlu.
     */
    protected function resolveKeyword(Request $request): string
    {
        // Coba semua input yang mungkin dipakai sebagai keyword
        return $request->input('nisn')
            ?? $request->input('nama')
            ?? $request->input('q')
            ?? '';
    }
}
