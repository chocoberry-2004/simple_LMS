<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // MySQL does not allow a referenced table to be truncated, even after
        // its child records have been removed. Reset this related data as one
        // foreign-key-safe operation so the seeder can be run repeatedly.
        Schema::withoutForeignKeyConstraints(function (): void {
            Borrowing::truncate();
            Member::truncate();
            Book::truncate();
            Category::truncate();
            Author::truncate();
            User::truncate();
        });


        User::factory(10)->create();
        Member::factory(10)->create();
        Category::factory(5)->create();
        Author::factory(10)->create();
        Book::factory(10)->create();
        Borrowing::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
