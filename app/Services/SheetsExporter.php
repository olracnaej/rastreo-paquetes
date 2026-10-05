<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;
use Throwable;

class SheetsExporter
{
    /**
     * Agrega una fila al historial de Google Sheets.
     * Si Sheets falla, el paquete ya quedó guardado en la base de datos:
     * solo se registra el error en el log.
     */
    public function append(Package $package, ?string $note = null): void
    {
        $sheetId = config('tracking.sheet_id');

        if (! $sheetId) {
            return; // Sheets no configurado todavía
        }

        try {
            Sheets::spreadsheet($sheetId)
                ->sheet(config('tracking.sheet_name'))
                ->append([[
                    now()->format('Y-m-d H:i'),
                    $package->tracking_id,
                    $package->customer_name,
                    $package->status,
                    $package->location,
                    optional($package->estimated_delivery)->format('Y-m-d'),
                    $note,
                ]]);
        } catch (Throwable $e) {
            Log::warning('No se pudo escribir en Google Sheets: '.$e->getMessage());
        }
    }
}
