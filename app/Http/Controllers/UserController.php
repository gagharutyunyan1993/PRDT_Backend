<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    public function show(int $id)
    {
        $user = User::find($id);

        return new UserResource($user);
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->only('first_name','last_name','email','role_id') +
            ['password' => Hash::make($request->input('password'))
        ]);

        return response(new UserResource($user),201);
    }

    public function update(Request $request,int $id)
    {
        $user = User::find($id);
        $user->update($request->only('first_name','last_name','email','role_id'));

        return response(new UserResource($user), 202);
    }

    public function destroy($id)
    {
        User::destroy($id);

        return response(null,204);
    }

    public function user()
    {
        return new UserResource(Auth::user());
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response(new UserResource($user), 202);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('first_name','last_name','email'));

        return response(new UserResource($user) , 202);
    }
}
