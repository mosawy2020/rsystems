<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
         $user = User::create($data);
        $user->token = $user->createToken('authToken')->plainTextToken;
        return UserResource::make($user)->additional(["success" => 1, "message" => ""]);
    }

}
