<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $response = Http::get('https://frontend-test-assignment-api.abz.agency/api/v1/positions');

        if ($response->successful()) {
            $positions = $response->json()['positions'] ?? [];

            foreach ($positions as $position) {
                \App\Models\Position::create(['name' => $position['name']]);
            }
        }

        \App\Models\User::factory(45)->create();
    }
}
