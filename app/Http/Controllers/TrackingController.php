<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $package = null;
        $searched = null;

        if ($request->filled('tracking_id')) {
            $searched = Package::normalize($request->string('tracking_id')->toString());
            $package = Package::with('events')->where('tracking_id', $searched)->first();
        }

        return view('tracking.index', compact('package', 'searched'));
    }
}
