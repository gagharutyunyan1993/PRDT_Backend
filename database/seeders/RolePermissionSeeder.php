<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use DB;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();

        $admin = Role::whereName('Admin')->first();

        foreach ($permissions as $permission) {
            DB::table('role_permission')->insert([
                'role_id' => $admin->id,
                'permission_id' => $permission->id
            ]);
        }

        $moderator = Role::whereName('Moderator')->first();

        foreach ($permissions as $permission) {
            if (!in_array($permission->name, ['edit_roles'])) {
                DB::table('role_permission')->insert([
                    'role_id' => $moderator->id,
                    'permission_id' => $permission->id
                ]);
            }
        }

        $guest = Role::whereName('Guest')->first();
        $guestRoles = [
            'view_users',
            'view_roles',
            'view_products',
            'view_orders'
        ];

        foreach ($permissions as $permission) {
            if (in_array($permission->name, $guestRoles)) {
                DB::table('role_permission')->insert([
                    'role_id' => $guest->id,
                    'permission_id' => $permission->id
                ]);
            }
        }
    }
}
