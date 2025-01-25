<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Catalog\Entities\Language;

class DefaultLanguages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['name' => 'فارسی'],
            ['name' => 'انگلیسی'],
            ['name' => 'عربی'],
            ['name' => 'اسپانیایی'],
            ['name' => 'آلمانی'],
            ['name' => 'فرانسوی'],
            ['name' => 'ایتالیایی'],
            ['name' => 'روسی'],
            ['name' => 'چینی'],
            ['name' => 'ژاپنی'],
            ['name' => 'کره‌ای'],
            ['name' => 'هندی'],
            ['name' => 'ترکی استانبولی'],
            ['name' => 'هلندی'],
            ['name' => 'سوئدی'],
            ['name' => 'نروژی'],
            ['name' => 'دانمارکی'],
            ['name' => 'لهستانی'],
            ['name' => 'یونانی'],
            ['name' => 'چکی'],
            ['name' => 'مجاری'],
            ['name' => 'رومانیایی'],
            ['name' => 'اوکراینی'],
            ['name' => 'تایلندی'],
            ['name' => 'ویتنامی'],
            ['name' => 'اندونزیایی'],
            ['name' => 'مالزیایی'],
            ['name' => 'فیلیپینی'],
            ['name' => 'پرتغالی'],
            ['name' => 'عبری'],
            ['name' => 'سوئدی'],
            ['name' => 'نروژی'],
            ['name' => 'دانمارکی'],
            ['name' => 'فنلاندی'],
            ['name' => 'ایسلندی'],
            ['name' => 'ایرلندی'],
            ['name' => 'لاتین'],
            ['name' => 'سوئدی'],
            ['name' => 'صربی'],
            ['name' => 'کرواتی'],
            ['name' => 'بلغاری'],
            ['name' => 'لیتوانیایی'],
            ['name' => 'لتونیایی'],
            ['name' => 'استونیایی'],
            ['name' => 'اسلونیایی'],
            ['name' => 'مقدونی'],
            ['name' => 'آلبانیایی'],
            ['name' => 'مالتی'],
            ['name' => 'بوسنیایی']
        ];

        foreach ($languages as $lang) {
            Language::create([
                'name' => $lang['name'],
                'status' => true,
                'adder' => 1
            ]);
        }
    }
}
