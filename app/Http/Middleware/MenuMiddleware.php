<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('username')) {
            $menus = [
                1 => [
                    'title' => 'مقادیر اولیه',
                    'link' => '',
                    'icon' => 'las la-cogs',
                    'permission' => "لیست مقادیر اولیه",
                    'childs' => [
                        [
                            'title' => 'دسترسی',
                            'link' => '/Permissions',
                            'permission' => "لیست دسترسی",
                            'icon' => 'las la-user-shield',
                        ],
                        [
                            'title' => 'نقش های کاربری',
                            'link' => '/Roles',
                            'permission' => "لیست نقش",
                            'icon' => 'las la-user-tag',
                        ],
                        [
                            'title' => 'قالب اثر',
                            'link' => '/catalog/post-formats',
                            'permission' => "لیست قالب اثر",
                            'icon' => 'lab la-wpforms',
                        ],
                        [
                            'title' => 'گروه علمی',
                            'link' => '/catalog/scientific-groups',
                            'permission' => "لیست گروه علمی",
                            'icon' => 'las la-user-friends',
                        ],
                    ]
                ],
                2 => [
                    'title' => 'نشر داخلی',
                    'link' => '',
                    'permission' => "منوی نشر داخلی",
                    'icon' => 'las la-book',
                    'childs' => [
                        [
                            'title' => 'مدیریت آثار',
                            'link' => '/internal-publication/posts',
                            'permission' => "نشر داخلی - مدیریت آثار",
                            'icon' => 'las la-mail-bulk',
                        ],
                    ]
                ],
                6 => [
                    'title' => 'مدیریت پرسنل',
                    'link' => '/Personnels',
                    'permission' => "لیست پرسنل",
                    'icon' => 'las la-users',
                    'childs' => []
                ],
                9 => [
                    'title' => 'مدیریت کاربران',
                    'link' => '/UserManager',
                    'permission' => "لیست کاربران",
                    'icon' => 'las la-users',
                    'childs' => []
                ],
                10 => [
                    'title' => 'بکاپ دیتابیس',
                    'link' => '/BackupDatabase',
                    'permission' => "لیست بکاپ دیتابیس",
                    'icon' => 'las la-hdd',
                    'childs' => []
                ],
            ];
            $request->session()->put('menus', $menus);
            return $next($request);
        }
        return response()->redirectToRoute('login');
    }
}
