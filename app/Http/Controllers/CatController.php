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
        // @TODO: Configure locally the SSL Certificate and remove verification bypass

        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'x-api-key' => config('services.cat_api.token'),
        ])
        ->get(config('services.cat_api.url') . '/images/search', request()->query());

        return $response->json();
    }
}
