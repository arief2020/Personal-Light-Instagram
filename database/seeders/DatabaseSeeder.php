<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use App\Models\Archive;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

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

        $users = User::factory(10)->create();

        foreach ($users as $user) {
            Post::factory(2)->create([
                'user_id' => $user->id,
            ]);

            Setting::factory(1)->create([
                'user_id' => $user->id,
            ]);
        }

        // Archive::factory(10)->create();
    }
}
