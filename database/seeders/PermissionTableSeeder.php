<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'index_menu',
            'create_menu',
            'update_menu',
            'delete_menu',

            'index_user',
            'create_user',
            'update_user',
            'delete_user',

            'index_log',
            'create_log',
            'update_log',
            'delete_log',

            'index_transaksi',
            'create_transaksi',
            'update_transaksi',
            'delete_transaksi',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
