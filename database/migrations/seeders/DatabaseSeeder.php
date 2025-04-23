<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        kelas::create([
            'nama_kelas' => 'Ruby',
        ]);

        User::create([
            'name' => 'admin',
            'nim' => 123,
            'email' => 'hmpstiub@gmail.com',
            'foto' => null,
            'status' => 'admin',
            'validate' => 'approved',
            'id_kelas' => 1,
            'no_hp' => '082112318744',
            'email_verified_at' => '2024-09-17 13:25:33',
            'password' => Hash::make('12345678'),
        ]);
    }
}
