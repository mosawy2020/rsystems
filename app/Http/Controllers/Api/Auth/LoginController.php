<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login (LoginRequest $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            $this->sendError(trans("auth.failed"),null,401) ;
            return response()->json([
                'message' => trans("auth.failed")
            ], 401);
        }
        $user =User::where('email', $request['email'])->firstOrFail();
        $user->token = $user->createToken('authToken')->plainTextToken;
        return UserResource::make($user)->additional(["success" => 1, "message" => ""]);
    }
}
