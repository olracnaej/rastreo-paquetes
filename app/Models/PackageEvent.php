<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageEvent extends Model
{
    protected $fillable = ['package_id', 'status', 'location', 'note'];
}
