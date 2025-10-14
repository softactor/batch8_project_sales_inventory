<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // create permission for roles
            [
                'name' => 'View Roles',
                'slug' => 'role.view',
                'group' => 'roles',
            ],
            [
                'name' => 'Create Roles',
                'slug' => 'role.create',
                'group' => 'roles',
            ],
            [
                'name' => 'Update Roles',
                'slug' => 'role.update',
                'group' => 'roles',
            ],
            [
                'name' => 'Delete Roles',
                'slug' => 'role.delete',
                'group' => 'roles',
            ],


            // create permission for users
            [
                'name' => 'View Users',
                'slug' => 'user.view',
                'group' => 'users',
            ],
            [
                'name' => 'Create Users',
                'slug' => 'user.create',
                'group' => 'users',
            ],
            [
                'name' => 'Update Users',
                'slug' => 'user.update',
                'group' => 'users',
            ],
            [
                'name' => 'Delete Users',
                'slug' => 'user.delete',
                'group' => 'users',
            ],
            
            // create permission for Categories
            [
                'name' => 'View Categories',
                'slug' => 'category.view',
                'group' => 'categories',
            ],
            [
                'name' => 'Create Categories',
                'slug' => 'category.create',
                'group' => 'categories',
            ],
            [
                'name' => 'Update Categories',
                'slug' => 'category.update',
                'group' => 'categories',
            ],
            [
                'name' => 'Delete Categories',
                'slug' => 'category.delete',
                'group' => 'categories',
            ],
            
            // create permission for Products
            [
                'name' => 'View Products',
                'slug' => 'product.view',
                'group' => 'products',
            ],
            [
                'name' => 'Create Products',
                'slug' => 'product.create',
                'group' => 'products',
            ],
            [
                'name' => 'Update Products',
                'slug' => 'product.update',
                'group' => 'products',
            ],
            [
                'name' => 'Delete Products',
                'slug' => 'product.delete',
                'group' => 'products',
            ],
            // create permission for Invoice
            [
                'name' => 'View Invoice',
                'slug' => 'invoice.view',
                'group' => 'invoice',
            ],
            [
                'name' => 'Create Invoice',
                'slug' => 'invoice.create',
                'group' => 'invoice',
            ],
            [
                'name' => 'Update Invoice',
                'slug' => 'invoice.update',
                'group' => 'invoice',
            ],
            [
                'name' => 'Delete Invoice',
                'slug' => 'invoice.delete',
                'group' => 'invoice',
            ],
            // create permission for Reports
            [
                'name' => 'View Reports',
                'slug' => 'report.view',
                'group' => 'reports',
            ],
            [
                'name' => 'Create Reports',
                'slug' => 'report.create',
                'group' => 'reports',
            ],
            [
                'name' => 'Update Reports',
                'slug' => 'report.update',
                'group' => 'reports',
            ],
            [
                'name' => 'Delete Reports',
                'slug' => 'report.delete',
                'group' => 'reports',
            ],

        ];

        // created all permissioins
        foreach($permissions as $permission)
        {
            Permission::create($permission);
        }

        // created one role Administrator
        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'System admin with all access',
        ]);
        // inserted role-Permission for Admin
        $adminRole->permissions()->sync(Permission::pluck('id')); // Permission::pluck('id') = [1, 2, 3, 4,......n] 

        // created one role Manager
        $managerRole = Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'description' => 'System Manager with limited access',
        ]);
        
        $managerPermissions = Permission::whereIn('slug', [
            'role.view',
            'user.create',
            'user.view',
            'product.view',
            'product.create',
            'invoice.view',
            'invoice.create',
            'report.create',
            'report.view',
        ])->pluck('id');

        // inserted role-Permission for Manager
        $managerRole->permissions()->sync($managerPermissions); // Permission::pluck('id') = [1, 2, 3, 4,......n] 
        

        // created one role User
        $userRole = Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'System User with general access',
        ]);

        $userPermissions = Permission::whereIn('slug', [
            'user.view',
            'product.view',
            'product.create',
            'invoice.view',
            'report.view',
        ])->pluck('id');

        // inserted role-Permission for User
        $userRole->permissions()->sync($userPermissions); // Permission::pluck('id') = [1, 2, 3, 4,......n] 

        //end of role, permission and permissioin-role table with above code:


        // get admin role id
        $adminRole = Role::where('slug', 'admin')->first();

        $adminUser = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'password',
            'phone' => '123456789',
        ]);


        $adminUser->roles()->sync($adminRole);
    }
}
