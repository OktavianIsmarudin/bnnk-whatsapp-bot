<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;

Route::get('/', function () {
    return response()->json([
        'app' => 'BNNK Surabaya WhatsApp Bot',
        'version' => '1.0.0',
        'status' => 'active'
    ]);
});

// WhatsApp Webhook Routes
Route::match(['get', 'post'], '/api/whatsapp/webhook', [WhatsAppController::class, 'webhook']);

// Simple webhook test
Route::get('/webhook-test', function(Illuminate\Http\Request $request) {
    \Log::info('Simple webhook test accessed:', $request->all());
    
    if ($request->has('hub_verify_token') && $request->has('hub_challenge')) {
        if ($request->hub_verify_token === 'bnnk_surabaya_2024_verify') {
            return response($request->hub_challenge, 200, ['Content-Type' => 'text/plain']);
        }
    }
    
    return response()->json(['status' => 'test endpoint working', 'params' => $request->all()]);
});

// Test route to check if bot is working
Route::get('/api/test', function () {
    return response()->json([
        'message' => 'BNNK Surabaya WhatsApp Bot is running',
        'timestamp' => now()->toDateTimeString(),
        'config' => [
            'verify_token_set' => config('whatsapp.verify_token') ? 'Yes' : 'No',
            'access_token_set' => config('whatsapp.access_token') ? 'Yes' : 'No',
            'phone_id_set' => config('whatsapp.phone_number_id') ? 'Yes' : 'No',
        ]
    ]);
});

// Admin Routes (add basic auth middleware in production)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard']);
    Route::get('/logs', [App\Http\Controllers\AdminController::class, 'logs']);
    Route::get('/analytics', [App\Http\Controllers\AdminController::class, 'analytics']);
});
