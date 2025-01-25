<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Catalog\Entities\PostSubject;

class DefaultPostSubjects extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postSubjects = [
            ['name' => 'علوم قرآن و حدیث'],
            ['name' => 'اجتماعی'],
            ['name' => 'سیاسی'],
        ];

        foreach ($postSubjects as $postSubject) {
            PostSubject::create([
                'name' => $postSubject['name'],
                'status' => true,
                'adder' => 1
            ]);
        }
    }
}
