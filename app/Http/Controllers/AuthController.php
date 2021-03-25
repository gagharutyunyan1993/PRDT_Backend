<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistorRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email','password')))
        {
            $user = Auth::user();

            $token = $user->createToken('admin')->accessToken;

            return [
              'token' => $token
            ];
        }

        return response([
            "error" => "Invalid Credentials!"
        ],401);
    }

    public function register(RegistorRequest $request)
    {
        $user = User::create($request->only('first_name','last_name','email','role_id') +
            ['password' => Hash::make($request->input('password'))
            ]);

        return response($user,201);
    }
}
