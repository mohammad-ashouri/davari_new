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

            //Internal Publication
            ['name' => 'منوی نشر داخلی', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - اثر جدید', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - ویرایش اثر', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - نمایش تاریخچه', 'guard_name' => 'web'],
            ['name' => 'نشر داخلی - مدیریت آثار - حذف اثر', 'guard_name' => 'web'],


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
