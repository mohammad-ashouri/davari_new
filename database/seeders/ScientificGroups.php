<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Catalog\Entities\ScientificGroup;

class ScientificGroups extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScientificGroup::insert([
                ['name' => 'فقه و اصول', 'adder' => 1],
                ['name' => 'اجتماعی و سیاسی', 'adder' => 1],
                ['name' => 'علوم انسانی', 'adder' => 1],
            ]
        );
    }
}
