<?php

namespace App\Http\Controllers\Api;

use App\Models\ContactMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreContactMessageRequest;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        $contactMessage = ContactMessage::query()->create($request->validated());

        return response()->json([
            'message' => 'Contact message created successfully.',
            'data' => $contactMessage,
        ], 201);
    }
}
