<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Services\SheetsExporter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest('updated_at')->paginate(20);

        return view('admin.index', compact('packages'));
    }

    /** Crea el paquete o, si el tracking ya existe, actualiza su estado. */
    public function store(Request $request, SheetsExporter $sheets)
    {
        $data = $request->validate([
            'tracking_id'        => ['required', 'string', 'max:60'],
            'status'             => ['required', Rule::in(config('tracking.stages'))],
            'location'           => ['nullable', 'string', 'max:120'],
            'note'               => ['nullable', 'string', 'max:255'],
            'customer_name'      => ['nullable', 'string', 'max:120'],
            'description'        => ['nullable', 'string', 'max:255'],
            'estimated_delivery' => ['nullable', 'date'],
        ]);

        $package = DB::transaction(function () use ($data) {
            $package = Package::firstOrNew([
                'tracking_id' => Package::normalize($data['tracking_id']),
            ]);

            $package->fill(Arr::only($data, ['status', 'location', 'estimated_delivery']));

            foreach (['customer_name', 'description'] as $field) {
                if (filled($data[$field] ?? null)) {
                    $package->{$field} = $data[$field];
                }
            }

            $package->save();

            $package->events()->create([
                'status'   => $data['status'],
                'location' => $data['location'] ?? null,
                'note'     => $data['note'] ?? null,
            ]);

            return $package;
        });

        $sheets->append($package, $data['note'] ?? null);

        return redirect()
            ->route('admin.packages.index')
            ->with('ok', "Guardado: {$package->tracking_id} ahora está en «{$package->status}».");
    }
}
