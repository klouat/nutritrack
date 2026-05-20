<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsdaProxyController extends Controller
{
    public function proxyUsdaApi(Request $request)
    {
        $query = $request->input('query');
        $apiKey = 'BGZb1QF3oOkTQzJOST1YQ63RgiTwC6Ni1HpesCVB';
        $url = 'https://api.nal.usda.gov/fdc/v1/foods/search';
        $response = Http::get($url, [
            'api_key' => $apiKey,
            'query' => $query,
            'pageSize' => 1
        ]);
        return response($response->body(), $response->status())
            ->header('Content-Type', 'application/json');
    }
} 