<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Catalog\Entities\PostFormat;

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
