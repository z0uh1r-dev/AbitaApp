<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class SwaggerJsonController extends Controller
{
    public function json(): JsonResponse
    {
        $path = storage_path('api-docs/api-docs.json');

        if (!file_exists($path)) {
            return response()->json(['error' => 'API documentation not found'], 404);
        }

        $json = json_decode(file_get_contents($path), true);

        return response()->json($json);
    }
}
