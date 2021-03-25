<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::paginate();
    }

    public function show(int $id)
    {
        return User::find($id);
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->only('first_name','last_name','email') +
            ['password' => Hash::make($request->input('password'))
        ]);

        return response($user,201);
    }

    public function update(Request $request,int $id)
    {
        $user = User::find($id);
        $user->update($request->only('first_name','last_name','email'));

        return response($user, 202);
    }

    public function destroy($id)
    {
        User::destroy($id);

        return response(null,204);
    }
}
