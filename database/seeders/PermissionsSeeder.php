<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Preparing the array of permissions
        $permissions = [
            ['name' => 'لیست مقادیر اولیه', 'guard_name' => 'web'],

            ['name' => 'لیست نقش', 'guard_name' => 'web'],
            ['name' => 'ایجاد نقش', 'guard_name' => 'web'],
            ['name' => 'ویرایش نقش', 'guard_name' => 'web'],
            ['name' => 'حذف نقش', 'guard_name' => 'web'],

            ['name' => 'لیست دسترسی', 'guard_name' => 'web'],
            ['name' => 'ایجاد دسترسی', 'guard_name' => 'web'],
            ['name' => 'ویرایش دسترسی', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات دسترسی', 'guard_name' => 'web'],
            ['name' => 'حذف دسترسی', 'guard_name' => 'web'],

            ['name' => 'لیست قالب اثر', 'guard_name' => 'web'],
            ['name' => 'ایجاد قالب اثر', 'guard_name' => 'web'],
            ['name' => 'ویرایش قالب اثر', 'guard_name' => 'web'],
            ['name' => 'حذف قالب اثر', 'guard_name' => 'web'],

            ['name' => 'لیست گروه علمی', 'guard_name' => 'web'],
            ['name' => 'ایجاد گروه علمی', 'guard_name' => 'web'],
            ['name' => 'ویرایش گروه علمی', 'guard_name' => 'web'],
            ['name' => 'حذف گروه علمی', 'guard_name' => 'web'],

            //Research
            ['name' => 'منوی پژوهش', 'guard_name' => 'web'],
            ['name' => 'پژوهش - مدیریت آثار', 'guard_name' => 'web'],
            ['name' => 'پژوهش - مدیریت آثار - اثر جدید', 'guard_name' => 'web'],
            ['name' => 'پژوهش - مدیریت آثار - ویرایش اثر', 'guard_name' => 'web'],
            ['name' => 'پژوهش - مدیریت آثار - نمایش تاریخچه', 'guard_name' => 'web'],
            ['name' => 'پژوهش - مدیریت آثار - حذف اثر', 'guard_name' => 'web'],

            ['name' => 'پژوهش - نمایش تاریخچه - ارسالی ادمین کل به مدیر گروه', 'guard_name' => 'web'],
            ['name' => 'پژوهش - نمایش تاریخچه - ارسالی ادمین کل به عضو گروه', 'guard_name' => 'web'],

            ['name' => 'پژوهش - نمایش تاریخچه - ارسالی عضو گروه به مدیر گروه', 'guard_name' => 'web'],

            ['name' => 'پژوهش - نمایش تاریخچه - ارسالی مدیر گروه به عضو گروه', 'guard_name' => 'web'],
            ['name' => 'پژوهش - نمایش تاریخچه - ارسالی مدیر گروه به مدیر پژوهش', 'guard_name' => 'web'],

            //Internal Publication
            ['name' => 'منوی نشر داخلی', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - اثر جدید', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - ویرایش اثر', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - ابطال اثر', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - نمایش تاریخچه', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - حذف اثر', 'guard_name' => 'web'],

            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به مدیر پژوهش', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به مدیر نشر داخلی', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به معاون', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به ویراستار', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به طراح', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به صفحه آرا', 'guard_name' => 'web'],

            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی مدیر پژوهش به مدیر گروه', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی مدیر پژوهش به مدیر نشر داخلی', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی مدیر پژوهش به معاون', 'guard_name' => 'web'],

            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی معاون به مدیر پژوهش', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی معاون به مدیر نشر داخلی', 'guard_name' => 'web'],

            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به معاون', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به مدیر پژوهش', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به ویراستار', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به طراح', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به صفحه آرا', 'guard_name' => 'web'],

            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی ویراستار به مدیر نشر داخلی', 'guard_name' => 'web'],

            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی طراح به مدیر نشر داخلی', 'guard_name' => 'web'],

            ['name' => 'نشر داخلی - نمایش تاریخچه - ارسالی صفحه آرا به مدیر نشر داخلی', 'guard_name' => 'web'],

            // Users Manager
            ['name' => 'لیست کاربران', 'guard_name' => 'web'],
            ['name' => 'ایجاد کاربر', 'guard_name' => 'web'],
            ['name' => 'ویرایش کاربر', 'guard_name' => 'web'],
            ['name' => 'تغییر وضعیت کاربر', 'guard_name' => 'web'],
            ['name' => 'تغییر وضعیت نیازمند به تغییر رمز عبور', 'guard_name' => 'web'],
            ['name' => 'بازنشانی رمز عبور کاربر', 'guard_name' => 'web'],

            // Database Backup
            ['name' => 'لیست بکاپ دیتابیس', 'guard_name' => 'web'],
            ['name' => 'ایجاد بکاپ دیتابیس', 'guard_name' => 'web'],

            ['name' => 'telescope', 'guard_name' => 'web']
        ];

        // Inserting the permissions into the database
        Permission::insert($permissions);

    }
}
