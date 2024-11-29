<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DefaultUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $password = bcrypt(12345678);

        DB::table('users')->insert([
            ['id' => 1, 'username' => 'admin', 'password' => $password, 'name' => 'Super', 'family' => 'Admin', 'type' => 1, 'subject' => 'ادمین کل', 'active' => 1, 'ntcp' => 0, 'adder' => 1],
            ['id' => 2, 'username' => 'farajnejad', 'password' => $password, 'name' => 'حسن', 'family' => 'فرج نژاد', 'type' => 2, 'subject' => 'معاون', 'active' => 1, 'ntcp' => 0, 'adder' => 1],
            ['id' => 3, 'username' => 'mostafavizadeh', 'password' => $password, 'name' => 'حسین', 'family' => 'مصطفوی زاده', 'type' => 3, 'subject' => 'مدیر پژوهش', 'active' => 1, 'ntcp' => 0, 'adder' => 1],
            ['id' => 4, 'username' => 'helali', 'password' => $password, 'name' => 'ابوالفضل', 'family' => 'هلالی', 'type' => 4, 'subject' => 'مدیر نشر داخلی', 'active' => 1, 'ntcp' => 0, 'adder' => 1],
            ['id' => 5, 'username' => 'modirgp', 'password' => $password, 'name' => 'مدیر', 'family' => 'گروه علمی', 'type' => 5, 'subject' => 'مدیر گروه علمی', 'active' => 1, 'ntcp' => 0, 'adder' => 1],
            ['id' => 6, 'username' => 'ozvgp', 'password' => $password, 'name' => 'عضو', 'family' => 'گروه', 'type' => 6, 'subject' => 'عضو گروه', 'active' => 1, 'ntcp' => 0, 'adder' => 1],
        ]);

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

            'لیست قالب اثر',
            'ایجاد قالب اثر',
            'ویرایش قالب اثر',
            'حذف قالب اثر',

            'لیست گروه علمی',
            'ایجاد گروه علمی',
            'ویرایش گروه علمی',
            'حذف گروه علمی',

            'لیست کاربران',
            'ایجاد کاربر',
            'ویرایش کاربر',
            'تغییر وضعیت کاربر',
            'تغییر وضعیت نیازمند به تغییر رمز عبور',
            'بازنشانی رمز عبور کاربر',
            'لیست بکاپ دیتابیس',
            'ایجاد بکاپ دیتابیس',
        ]);

        $createRole = Role::create(['name' => 'معاون']);
        $createRole->givePermissionTo([
            'لیست مقادیر اولیه',

            'لیست قالب اثر',
            'ایجاد قالب اثر',
            'ویرایش قالب اثر',
            'حذف قالب اثر',

            'لیست گروه علمی',
            'ایجاد گروه علمی',
            'ویرایش گروه علمی',
            'حذف گروه علمی',

            'لیست کاربران',
            'ایجاد کاربر',
            'ویرایش کاربر',
            'تغییر وضعیت کاربر',
            'تغییر وضعیت نیازمند به تغییر رمز عبور',
            'بازنشانی رمز عبور کاربر',
            'لیست بکاپ دیتابیس',
            'ایجاد بکاپ دیتابیس',
        ]);

        $createRole = Role::create(['name' => 'مدیر پژوهش']);
        $createRole->givePermissionTo([
            'لیست مقادیر اولیه',

            'لیست قالب اثر',
            'ایجاد قالب اثر',
            'ویرایش قالب اثر',
            'حذف قالب اثر',

            'لیست گروه علمی',
            'ایجاد گروه علمی',
            'ویرایش گروه علمی',
            'حذف گروه علمی',

            'لیست کاربران',
            'ایجاد کاربر',
            'ویرایش کاربر',
            'تغییر وضعیت کاربر',
            'تغییر وضعیت نیازمند به تغییر رمز عبور',
            'بازنشانی رمز عبور کاربر',
            'لیست بکاپ دیتابیس',
            'ایجاد بکاپ دیتابیس',
        ]);


        $createRole = Role::create(['name' => 'مدیر نشر داخلی']);
        $createRole->givePermissionTo([
        ]);

        $createRole = Role::create(['name' => 'مدیر گروه علمی']);
        $createRole->givePermissionTo([
        ]);

        $createRole = Role::create(['name' => 'عضو گروه']);
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
        $user = User::find(1);
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'مدیر پژوهش')->first();
        $user = User::find(3);
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'معاون')->first();
        $user = User::find(2);
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'مدیر نشر داخلی')->first();
        $user = User::find(4);
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'مدیر گروه علمی')->first();
        $user = User::find(5);
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'عضو گروه')->first();
        $user = User::find(6);
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
