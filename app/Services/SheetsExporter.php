<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class SheetsExporter
{
    /**
     * Envía una fila al historial de Google Sheets (vía Apps Script).
     * Si falla, el paquete ya quedó guardado en la base de datos.
     */
    public function append(Package $package, ?string $note = null): void
    {
        $url = config('tracking.sheets_url');

        if (! $url) {
            return; // Sheets no configurado todavía
        }

        try {
            $response = Http::timeout(10)->asJson()->post($url, [
                'secret' => config('tracking.sheets_secret'),
                'row' => [
                    now()->timezone('America/Costa_Rica')->format('Y-m-d H:i'),
                    $package->tracking_id,
                    $package->customer_name,
                    $package->status,
                    $package->location,
                    optional($package->estimated_delivery)->format('Y-m-d'),
                    $note,
                ],
            ]);

            if ($response->failed() || trim($response->body()) !== 'ok') {
                Log::warning('Google Sheets respondió algo inesperado: '.$response->body());
            }
        } catch (Throwable $e) {
            Log::warning('No se pudo escribir en Google Sheets: '.$e->getMessage());
        }
    }
}
