<?php

namespace Database\Seeders;

use App\Models\UrlOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UrlOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UrlOption::factory()->create([
            'name' => 'next_id',
            'value' => '1',
        ]);
    }
}
