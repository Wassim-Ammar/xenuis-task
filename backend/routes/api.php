<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('candidats/cv/{candidat}', [CandidatController::class, 'getCv']);

Route::post('add-cv', [CandidatController::class, 'store']);
Route::middleware('auth:sanctum')->controller(AuthController::class)
    ->group(function () {
        Route::get('me', 'me');
        Route::get('logout', 'logout');
        Route::post('login', 'authenticate')->withoutMiddleware('auth:sanctum');
        Route::post('register', 'register')->withoutMiddleware('auth:sanctum');

        Route::resources([
            'users' => UserController::class,
        ]);



        Route::resources([
            'offers' => OfferController::class,
        ]);


        Route::post('candidats/apply/{offer}', [CandidatController::class, 'apply']);

        Route::post(
            'candidats/send-email',
            [
                CandidatController::class,
                'sendEmailToTheCandidat'
            ]
        );

        Route::resources([
            'candidats' => CandidatController::class,
        ]);
    });
