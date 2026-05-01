<?php

namespace App\Observers;

use App\Models\Instansi;
use Illuminate\Support\Facades\Cache;

class InstansiObserver
{
    /**
     * Flush cache instansi setiap kali data disimpan atau dihapus.
     * Dipanggil otomatis oleh Eloquent saat: created, updated, deleted.
     */
    public function saved(Instansi $instansi): void
    {
        Cache::tags('instansi')->flush();
    }

    public function deleted(Instansi $instansi): void
    {
        Cache::tags('instansi')->flush();
    }
}
