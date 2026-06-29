<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Api\AuthController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Vocabulary learning endpoints
    Route::get('/vocab-sets', [\App\Http\Controllers\Api\VocabController::class, 'index']);
    Route::get('/vocab-groups/{groupId}/words', [\App\Http\Controllers\Api\VocabController::class, 'groupWords']);
    Route::post('/user-progress', [\App\Http\Controllers\Api\VocabController::class, 'saveProgress']);

    // Rich content endpoints
    Route::get('/common-sentences', [\App\Http\Controllers\Api\RichContentController::class, 'getCommonSentences']);
    Route::get('/hsk-listening-tests', [\App\Http\Controllers\Api\RichContentController::class, 'getHskListeningTests']);
    Route::get('/video-lectures', [\App\Http\Controllers\Api\RichContentController::class, 'getVideoLectures']);
    Route::get('/user-stats', [\App\Http\Controllers\Api\RichContentController::class, 'getUserStats']);
    Route::get('/custom-vocabularies', [\App\Http\Controllers\Api\RichContentController::class, 'getCustomVocabularies']);
    Route::post('/custom-vocabularies', [\App\Http\Controllers\Api\RichContentController::class, 'saveCustomVocabulary']);
});
