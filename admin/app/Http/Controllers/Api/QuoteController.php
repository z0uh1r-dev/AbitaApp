<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreQuoteRequest;
use App\Mail\NewQuoteForAdmin;
use App\Mail\QuoteReceivedConfirmation;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        try {
            $quote = Quote::query()->create($request->validated());
            $quote->refresh();
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Unable to create quote. Please try again later.',
            ], 500);
        }

        $adminEmails = User::query()
            ->where('role', UserRole::SuperAdmin)
            ->where('status', UserStatus::Active)
            ->pluck('email')
            ->filter()
            ->values()
            ->all();

        if ($adminEmails !== []) {
            try {
                Mail::to($adminEmails)->send(new NewQuoteForAdmin($quote));
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        try {
            Mail::to($quote->email)->send(new QuoteReceivedConfirmation($quote));
        } catch (Throwable $exception) {
            report($exception);
        }

        return response()->json([
            'message' => 'Quote created successfully.',
            'data' => $quote,
        ], 201);
    }
}
