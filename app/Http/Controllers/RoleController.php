<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Gate::authorize('view','roles');

        return RoleResource::collection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        Gate::authorize('edit','roles');

        $role = Role::create($request->only('name'));

        if($permissions = $request->input('permissions'))
        {
            foreach ($permissions as $permission_id)
            {
                DB::table('role_permission')->insert([
                   'role_id' => $role->id,
                   'permission_id' => $permission_id
                ]);
            }
        }

        return response(new RoleResource($role), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return RoleResource
     */
    public function show($id): RoleResource
    {
        Gate::authorize('view','roles');

        return new RoleResource(Role::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id): Response
    {
        Gate::authorize('edit','roles');

        $role = Role::find($id);

        $role->update($request->only('name'));

        DB::table('role_permission')->where('role_id',$role->id)->delete();

        if($permissions = $request->input('permissions'))
        {
            foreach ($permissions as $permission_id)
            {
                DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        return response(new RoleResource($role), 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id): Response
    {
        Gate::authorize('edit','roles');

        DB::table('role_permission')->where('role_id',$id)->delete();

        Role::destroy($id);

        return response(null,204);
    }
}
