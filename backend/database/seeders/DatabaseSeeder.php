<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ToDoItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create(['email' => 'wassim@example.tn', 'role' => 2])->each(function ($user) {
            \App\Models\Candidat::factory()->create(['user_id' => $user->id]);
        });
        \App\Models\User::factory(1)->create(['email' => 'wassim@admin.tn', 'role' => 1])->each(function ($user) {
            \App\Models\Administrator::factory()->create(['user_id' => $user->id]);
        });

        \App\Models\Offer::factory()->create(['title' => 'Backend developer']);

        \App\Models\Offer::factory()->create(['title' => 'Frontend developer']);
    }
}
