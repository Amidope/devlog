<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'is_admin' => true,
            'email' => 'mail@gman',
            'password' => Hash::make('blackmesa'),
        ]);
        $users = User::factory(10)->create();
        $posts = Post::factory(20)->recycle($admin)->create();

        Comment::factory(100)
            ->recycle($posts)
            ->recycle($users)
            ->create();
    }
}
