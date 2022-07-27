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
     
        $permissions = ['5', '6', '7', '8', '9'];
   
        $role->syncPermissions($permissions);
     
        $user->assignRole(1);

        // kasir
        $kasir = User::create([
            'name' => 'Kasir', 
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('123456')
        ]);
    
        $roleKasir = Role::create(['name' => 'kasir']);
     
        $permissionsKasir = ['13', '14', '15', '16'];
   
        $roleKasir->syncPermissions($permissionsKasir);
     
        $kasir->assignRole(2);

        // manager
        $manager = User::create([
            'name' => 'Manager', 
            'email' => 'manager@gmail.com',
            'password' => bcrypt('123456')
        ]);
    
        $roleManager = Role::create(['name' => 'manager']);
     
        $permissionsManager = ['1', '2', '3', '4', '13','9'];
   
        $roleManager->syncPermissions($permissionsManager);
     
        $manager->assignRole(3);
    }
}
