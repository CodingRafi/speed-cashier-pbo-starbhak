<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meja;
use App\Models\Kategori;
use App\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(UserSeeder::class);

        Meja::create([
            'no_meja' => 1
        ]);

        Kategori::create([
            'nama' => 'Makanan'
        ]);

        Menu::create([
            'nama' => 'Nasi Goreng',
            'harga' => 12000,
            'kategori_id' => 1
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
