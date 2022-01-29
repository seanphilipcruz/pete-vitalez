<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Product::factory(15)->create();
        Role::factory(3)->create();
        User::factory(1)->create();
        Blog::factory(21)->create();
        Product::factory(15)->create();
    }
}
