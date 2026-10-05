<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'tracking_id', 'customer_name', 'description',
        'status', 'location', 'estimated_delivery',
    ];

    protected $casts = ['estimated_delivery' => 'date'];

    /** Quita espacios y pasa a mayúsculas: "tba 123 456" -> "TBA123456". */
    public static function normalize(string $value): string
    {
        return strtoupper(preg_replace('/\s+/', '', $value));
    }

    public function events(): HasMany
    {
        return $this->hasMany(PackageEvent::class)->latest()->latest('id');
    }

    /** Posición (0..n) del estado actual dentro de las etapas. */
    public function stageIndex(): int
    {
        $i = array_search($this->status, config('tracking.stages'), true);

        return $i === false ? 0 : $i;
    }
}
