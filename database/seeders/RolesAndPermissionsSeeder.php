<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // MISC
        $miscPermission = Permission::create(['name' => 'N/A']);

        //USER MODEL
        $userPermissionCreate = Permission::create(['name' => 'create: user']);
        $userPermissionRead = Permission::create(['name' => 'read: user']);
        $userPermissionUpdate = Permission::create(['name' => 'update: user']);
        $userPermissionDelete = Permission::create(['name' => 'delete: user']);

        //ROLE MODEL
        $rolePermissionCreate = Permission::create(['name' => 'create: role']);
        $rolePermissionRead = Permission::create(['name' => 'read: role']);
        $rolePermissionUpdate = Permission::create(['name' => 'update: role']);
        $rolePermissionDelete = Permission::create(['name' => 'delete: role']);

        //PERMISSION MODEL
        $permissionCreate = Permission::create(['name' => 'create: permission']);
        $permissionRead = Permission::create(['name' => 'read: permission']);
        $permissionUpdate = Permission::create(['name' => 'update: permission']);
        $permissionDelete = Permission::create(['name' => 'delete: permission']);

        //ADMINS
        $adminPermissionRead = Permission::create(['name' => 'read: admin']);
        $adminPermissionUpdate = Permission::create(['name' => 'update: admin']);

        //CREATE ROLES
        $userRole = Role::create(['name' => 'user'])->syncPermissions([
            $miscPermission,
        ]);

        $superAdminRole = Role::create(['name' => 'super-admin'])->syncPermissions([
            $userPermissionCreate,
            $userPermissionRead,
            $userPermissionUpdate,
            $userPermissionDelete,
            $rolePermissionCreate,
            $rolePermissionRead,
            $rolePermissionUpdate,
            $rolePermissionDelete,
            $permissionCreate,
            $permissionRead,
            $permissionUpdate,
            $permissionDelete,
            $adminPermissionRead,
            $adminPermissionUpdate,
            $userPermissionCreate,
        ]);

        $adminRole = Role::create(['name' => 'admin'])->syncPermissions([
            $userPermissionCreate,
            $userPermissionRead,
            $userPermissionUpdate,
            $userPermissionDelete,
            $rolePermissionCreate,
            $rolePermissionRead,
            $rolePermissionUpdate,
            $rolePermissionDelete,
            $permissionCreate,
            $permissionRead,
            $permissionUpdate,
            $permissionDelete,
            $adminPermissionRead,
            $adminPermissionUpdate,
            $userPermissionCreate,
        ]);

        $moderatorRole = Role::create(['name' => 'moderator'])->syncPermissions([
            $userPermissionRead,
            $rolePermissionRead,
            $permissionRead,
            $adminPermissionRead,
        ]);

        $developerRole = Role::create(['name' => 'developer'])->syncPermissions([
            $adminPermissionRead,
        ]);

        User::create([
            'name' => 'super-admin',
            'is_admin' => true,
            'email' => 'super-admin@bihtalentfactory.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($superAdminRole);

        User::create([
            'name' => 'admin',
            'is_admin' => true,
            'email' => 'admin@bihtalentfactory.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($adminRole);

        User::create([
            'name' => 'moderator',
            'is_admin' => true,
            'email' => 'moderator@bihtalentfactory.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($moderatorRole);

        User::create([
            'name' => 'developer',
            'is_admin' => true,
            'email' => 'developer@bihtalentfactory.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($developerRole);

        for($i=1; $i<5; $i++){
            User::create([
                'name' => 'testUser '.$i,
                'is_admin' => false,
                'email' => 'testuser'.$i.'@bihtalentfactory.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ])->assignRole($userRole);
        }
    }
}
