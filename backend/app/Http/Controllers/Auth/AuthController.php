<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\AuthRequest;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\DataResponse;
use App\Http\Responses\MessageResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\RegisterUser;
use App\Http\Requests\UserRequest;
use App\Models\Administrator;
use App\Models\Candidat;
use Illuminate\Auth\Events\Registered;

class AuthController
{

    public function register(UserRequest $request): JsonResponse
    {

        return ($request->store()) ? ApiResponse::success() : ApiResponse::error('Regestration failed');
    }

    public function authenticate(AuthRequest $request): JsonResponse
    {

        if ($request->authenticate()) {
            $request->session()->regenerate();

            if (Auth::user()->role == 1) {

                return ApiResponse::success(Administrator::where('user_id', Auth::user()->id)->with('user')->get()[0]);
            } else

                return ApiResponse::success(Candidat::where('user_id', Auth::user()->id)->with('user')->get()[0]);
        }


        return ApiResponse::error('The provided credentials do not match our records.');
    }

    public function me(): JsonResponse
    {
        if (Auth::user()->role == 1)
            return ApiResponse::success(Administrator::where('user_id', Auth::user()->id)->with('user')->get()[0]);
        else

            return ApiResponse::success(Candidat::where('user_id', Auth::user()->id)->with('user')->get()[0]);
    }
}
