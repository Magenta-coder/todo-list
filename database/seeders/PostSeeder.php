<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'title' => 'Promo Product X',
            'brand' => 'Brand X',
            'platform' => 'Instagram',
            'due_date' => '2025-03-01',
            'payment' => 100.00,
            'status' => 'pending',
        ]);
    }
}
