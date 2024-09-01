<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use AppLogger\Logger\Models\Log;

// Route to create a new log
Route::post('/logs', function (Request $request) {
    $validatedData = $request->validate([
        'arrival_date' => 'required|date_format:Y-m-d H:i:s',
        'user_name' => 'required|string',
        'delay' => 'required|integer',
    ]);

    $log = new Log();
    $log->arrival_date = $validatedData['arrival_date'];
    $log->user_name = $validatedData['user_name'];
    $log->delay = $validatedData['delay'];
    $log->save();

    return response()->json(['success' => true, 'log' => $log]);
});

// Route to get all logs
Route::get('/logs', function () {
    return Log::all();
});

Route::get('/logs/user/{name}', function ($name) {
    return Log::where('user_name', $name)->get();
});

Route::get('/logs/sorted/arrival', function () {
    return Log::orderBy('arrival_date', 'desc')->get();
});

Route::get('/logs/sorted/delay', function () {
    return Log::orderBy('delay', 'desc')->get();
});

Route::get('/logs/early', function () {
    return Log::where('log_type', 'early')->get();
});

Route::get('/logs/on-time', function () {
    return Log::where('log_type', 'on_time')->get();
});

Route::get('/logs/late', function () {
    return Log::where('log_type', 'late')->get();
});

Route::get('/logs/absent', function () {
    return Log::where('log_type', 'absent')->get();
});
