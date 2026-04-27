<?php

namespace App\Filament\Concerns;

use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Validators\Failure;

trait HasImportActions
{
    /**
     * Resolve path dari filename Filament upload (disk local, dir imports-tmp).
     */
    protected function resolveUpload(string $filename): string
    {
        $path = storage_path('app/private/'.$filename);

        if (! file_exists($path)) {
            throw new \RuntimeException("Uploaded file not found: {$filename}");
        }

        return $path;
    }

    /**
     * Kirim notifikasi berdasarkan hasil array {berhasil, dilewati, gagal, log}.
     *
     * @param  array{berhasil: int, dilewati: int, gagal: int, log: string[]}  $result
     */
    protected function sendImportNotification(array $result, string $prefix): void
    {
        $isWarning = $result['gagal'] > 0 || $result['dilewati'] > 0;

        $title = "{$prefix}: {$result['berhasil']} berhasil"
            .($result['dilewati'] ? ", {$result['dilewati']} dilewati" : '')
            .($result['gagal'] ? ", {$result['gagal']} gagal" : '');

        $body = implode("\n", array_slice($result['log'], 0, 8));
        if (count($result['log']) > 8) {
            $body .= "\n... dan ".(count($result['log']) - 8).' lainnya.';
        }

        Notification::make()
            ->title($title)
            ->body($body)
            ->when($isWarning, fn ($n) => $n->warning(), fn ($n) => $n->success())
            ->persistent()
            ->send();
    }

    /**
     * Kirim notifikasi hasil import Excel (ToModel/WithValidation pattern).
     *
     * @param  Collection<int, Failure>  $failures
     */
    protected function sendExcelNotification(int $berhasil, Collection $failures, string $entity): void
    {
        if ($failures->count() > 0) {
            $messages = $failures
                ->map(fn (Failure $f) => "Baris {$f->row()}: ".implode(', ', $f->errors()))
                ->take(5)
                ->join("\n");

            Notification::make()
                ->title("Import selesai — {$berhasil} berhasil, {$failures->count()} baris gagal")
                ->body($messages)
                ->warning()
                ->persistent()
                ->send();

            return;
        }

        Notification::make()
            ->title("{$berhasil} data {$entity} berhasil diimpor!")
            ->success()
            ->send();
    }
}
