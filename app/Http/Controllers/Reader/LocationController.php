<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function fetchAll(): \Illuminate\Http\JsonResponse
    {
        try {
            $all = Location::query()
                ->whereNull('parent_id')
                ->with(['child'])
                ->orderBy('name')
                ->get()->toArray();

            return response()->json(['status' => 'success', 'data' => $all], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 400);
        }
    }
}
