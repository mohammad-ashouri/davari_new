<?php

namespace Database\Seeders;

use App\Models\Catalogs\PostFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostFormats extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostFormat::insert([
            ['name' => 'کتاب','adder' => 1],
            ['name' => 'مقاله','adder' => 1]
        ]);
    }
}
