<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Snapshot;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Riyaldi',
            'email' => 'tes@mail.com',
            'password' => 'kepokepo'
        ]);
        User::factory(10)->create();

        Snapshot::factory(50)->create();

        Admin::factory(1)->create();
    }
}
