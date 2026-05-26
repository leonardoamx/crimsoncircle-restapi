<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CatBreedController extends Controller
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
        ])->get(config('services.cat_api.url') . '/breeds', request()->query());

        return $response->json();
    }
}
