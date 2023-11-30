<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\DataResponse;
use App\Http\Responses\GeneralResponse;
use App\Http\Responses\MessageResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;

class UserController extends Controller
{

    public function index(): JsonResponse
    {

        $users = User::select('id', 'name', 'email', 'surname', 'cin', 'address', 'mobile', 'role', 'city', 'state', 'permission')->get();
        return ApiResponse::success($users);
    }



    public function store(UserRequest $request)
    {
        $request->store();
        return $this->index();
    }


    public function show(): JsonResponse
    {
        return ApiResponse::success(Auth::user());
    }


    public function update(User $user, UserRequest $request): JsonResponse
    {

        $request->update($user);

        return $this->index();
    }


    public function destroy(string $id)
    {
        User::where('id', Auth::user()->id)->delete();
        return $this->index();
    }

    public function changePassword(User $user, Request $request): JsonResponse
    {
        $old_password = Hash::make($request->old_password);
        if (strcmp($user->password, $old_password) == 0) {
            return ApiResponse::success();
        }
        return ApiResponse::error('incorrect password');
    }
}
