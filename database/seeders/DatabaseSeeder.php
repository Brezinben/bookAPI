<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@test.test',
            'email_verified_at' => now(),
            'password' => '$2y$10$mttNYM2b22cTtM7yEgkureYwor2utv9CXGSXZAZgo2A2JDLLFN34u', // admin1234
            'remember_token' => Str::random(10)
        ]);

        echo("Éditeur : " . substr($user->createToken('Editor', ['create', 'read', 'update'])->plainTextToken, 2) . "\n");
        echo("Admin   : " . substr($user->createToken('Admin', ['create', 'read', 'update', 'delete'])->plainTextToken, 2) . "\n");

        Author::factory(50)->create();
        Category::factory(10)->create();
        Book::factory(150)->create();
    }
}
