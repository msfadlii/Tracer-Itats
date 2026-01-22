<?php

use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;

Route::get('/analytics/summary', [AnalyticsController::class, 'summary']);
