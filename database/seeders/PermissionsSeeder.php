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
            ['name' => 'نمایش جزئیات نقش', 'guard_name' => 'web'],
            ['name' => 'حذف نقش', 'guard_name' => 'web'],

            ['name' => 'لیست دسترسی', 'guard_name' => 'web'],
            ['name' => 'ایجاد دسترسی', 'guard_name' => 'web'],
            ['name' => 'ویرایش دسترسی', 'guard_name' => 'web'],
            ['name' => 'نمایش جزئیات دسترسی', 'guard_name' => 'web'],
            ['name' => 'حذف دسترسی', 'guard_name' => 'web'],

            ['name' => 'لیست پرسنل', 'guard_name' => 'web'],
            ['name' => 'ایجاد پرسنل', 'guard_name' => 'web'],
            ['name' => 'ویرایش پرسنل', 'guard_name' => 'web'],
            ['name' => 'ویرایش تجهیزات پرسنل', 'guard_name' => 'web'],
            ['name' => 'انتقال تجهیزات پرسنل', 'guard_name' => 'web'],

            // Users Manager
            ['name' => 'لیست کاربران', 'guard_name' => 'web'],
            ['name' => 'ایجاد کاربر', 'guard_name' => 'web'],
            ['name' => 'ویرایش کاربر', 'guard_name' => 'web'],
            ['name' => 'تغییر وضعیت کاربر', 'guard_name' => 'web'],
            ['name' => 'تغییر وضعیت نیازمند به تغییر رمز عبور', 'guard_name' => 'web'],
            ['name' => 'بازنشانی رمز عبور کاربر', 'guard_name' => 'web'],
            ['name' => 'جستجوی کاربر', 'guard_name' => 'web'],

            // Database Backup
            ['name' => 'لیست بکاپ دیتابیس', 'guard_name' => 'web'],
            ['name' => 'ایجاد بکاپ دیتابیس', 'guard_name' => 'web'],

            ['name' => 'telescope', 'guard_name' => 'web']
        ];

        // Inserting the permissions into the database
        Permission::insert($permissions);

        $createRole = Role::create(['name' => 'ادمین کل']);
        $createRole->givePermissionTo([
            'telescope',
            'لیست مقادیر اولیه',

            'لیست نقش',
            'ایجاد نقش',
            'ویرایش نقش',
            'نمایش جزئیات نقش',
            'حذف نقش',

            'لیست دسترسی',
            'ایجاد دسترسی',
            'ویرایش دسترسی',
            'نمایش جزئیات دسترسی',
            'حذف دسترسی',

            'لیست کاربران',
            'ایجاد کاربر',
            'ویرایش کاربر',
            'تغییر وضعیت کاربر',
            'تغییر وضعیت نیازمند به تغییر رمز عبور',
            'بازنشانی رمز عبور کاربر',
            'جستجوی کاربر',
            'لیست بکاپ دیتابیس',
            'ایجاد بکاپ دیتابیس',
        ]);

        $createRole = Role::create(['name' => 'معاون']);
        $createRole->givePermissionTo([
            'لیست مقادیر اولیه',

            'لیست کاربران',
            'ایجاد کاربر',
            'ویرایش کاربر',
            'تغییر وضعیت کاربر',
            'تغییر وضعیت نیازمند به تغییر رمز عبور',
            'بازنشانی رمز عبور کاربر',
            'جستجوی کاربر',
            'لیست بکاپ دیتابیس',
            'ایجاد بکاپ دیتابیس',
        ]);

        $createRole = Role::create(['name' => 'مدیر پژوهش']);
        $createRole->givePermissionTo([
            'لیست مقادیر اولیه',

            'لیست کاربران',
            'ایجاد کاربر',
            'ویرایش کاربر',
            'تغییر وضعیت کاربر',
            'تغییر وضعیت نیازمند به تغییر رمز عبور',
            'بازنشانی رمز عبور کاربر',
            'جستجوی کاربر',
            'لیست بکاپ دیتابیس',
            'ایجاد بکاپ دیتابیس',
        ]);

        $createRole = Role::create(['name' => 'مدیر اجرایی']);
        $createRole->givePermissionTo([
        ]);

//        $createRole = Role::create(['name' => 'ویراستار']);
//        $createRole->givePermissionTo([
//        ]);
//
//        $createRole = Role::create(['name' => 'طراح']);
//        $createRole->givePermissionTo([
//        ]);
//
//        $createRole = Role::create(['name' => 'صفحه آرا']);
//        $createRole->givePermissionTo([
//        ]);

        $role = Role::where('name', 'ادمین کل')->first();
        $users = User::get();
        foreach ($users as $user) {
            $user = User::findOrFail($user->id);
            $user->assignRole([$role->id]);
        }

        $role = Role::where('name', 'مدیر پژوهش')->first();
        $user = User::find(3);
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'معاون')->first();
        $user = User::find(2);
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'مدیر اجرایی')->first();
        $user = User::find(4);
        $user->assignRole([$role->id]);

//        $role = Role::where('name', 'ویراستار')->first();
//        $user = User::find(5);
//        $user->assignRole([$role->id]);
//
//        $role = Role::where('name', 'طراح')->first();
//        $user = User::find(6);
//        $user->assignRole([$role->id]);
//
//        $role = Role::where('name', 'صفحه آرا')->first();
//        $user = User::find(7);
//        $user->assignRole([$role->id]);
    }
}
