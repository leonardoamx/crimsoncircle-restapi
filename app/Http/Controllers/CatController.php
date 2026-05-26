<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::withHeaders([
            'x-api-key' => config('services.cat_api.token'),
        ])
        ->get(config('services.cat_api.url') . '/images/search', request()->query());

        return $response->json();
    }
}
