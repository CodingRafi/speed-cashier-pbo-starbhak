<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);
    
        $role = Role::create(['name' => 'admin']);
     
        $permissions = ['5', '6', '7', '8', '9', '21'];
   
        $role->syncPermissions($permissions);
     
        $user->assignRole(1);

        // kasir
        $kasir = User::create([
            'name' => 'Kasir', 
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('123456')
        ]);
    
        $roleKasir = Role::create(['name' => 'kasir']);
     
        $permissionsKasir = ['13', '14', '15', '16', '21'];
   
        $roleKasir->syncPermissions($permissionsKasir);
     
        $kasir->assignRole(2);

        // manager
        $manager = User::create([
            'name' => 'Manager', 
            'email' => 'manager@gmail.com',
            'password' => bcrypt('123456')
        ]);
    
        $roleManager = Role::create(['name' => 'manager']);
     
        $permissionsManager = ['1', '2', '3', '4', '13','9', '17', '18', '19', '20', '21', '22'];
   
        $roleManager->syncPermissions($permissionsManager);
     
        $manager->assignRole(3);

        // super admin
        // $super_admin = User::create([
        //     'name' => 'Super Admin', 
        //     'email' => 'superadmin@gmail.com',
        //     'password' => bcrypt('123456')
        // ]);
    
        // $roleSuperAdmin = Role::create(['name' => 'superadmin']);
     
        // $permissionSuperAdmin = ['1', '2', '3', '4', '13','9', '17', '18', '19', '20', '21', '22'];
   
        // $roleSuperAdmin->syncPermissions($permissionSuperAdmin);
     
        // $super_admin->assignRole(3);
    }
}
