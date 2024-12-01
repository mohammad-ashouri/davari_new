<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Building;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Catalog\Entities\ScientificGroup;
use Spatie\Permission\Models\Role;

class UserManager extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کاربران', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کاربر', ['only' => ['newUser']]);
        $this->middleware('permission:ویرایش کاربر', ['only' => ['editUser']]);
        $this->middleware('permission:تغییر وضعیت کاربر', ['only' => ['ChangeUserActivationStatus']]);
        $this->middleware('permission:تغییر وضعیت نیازمند به تغییر رمز عبور', ['only' => ['ChangeUserNTCP']]);
        $this->middleware('permission:بازنشانی رمز عبور کاربر', ['only' => ['ResetPassword']]);
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userList = User::orderBy('id', 'asc')->paginate(10);
        $allRoles = Role::get();
        $groups = ScientificGroup::whereStatus(1)->orderBy('name')->get();
        return view('UserManager', compact('userList', 'allRoles', 'groups'));
    }

    public function ChangeUserActivationStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        $username = $request->input('username');
        $user = User::where('username', $username)->first();
        if ($username and $user) {
            $userStatus = User::where('username', $username)->value('active');
            if ($userStatus == 1) {
                $status = 0;
                $subject = 'Deactivated';
                $subject2 = 'غیرفعال';
            } elseif ($userStatus == 0) {
                $status = 1;
                $subject = 'Activated';
                $subject2 = 'فعال';
            }

            $user->active = $status;
            $user->save();
            return $this->success(true, 'changedUserActivation', 'کاربر با موفقیت ' . $subject2 . ' شد.');
        } else {
            return $this->alerts(false, 'changedUserActivationFailed', 'خطا در انجام عملیات');
        }
    }

    public function ChangeUserNTCP(Request $request): \Illuminate\Http\JsonResponse
    {

        $username = $request->input('username');
        $user = User::where('username', $username)->first();
        if ($username and $user) {
            $userNTCP = User::where('username', $username)->value('NTCP');
            if ($userNTCP == 1) {
                $status = 0;
                $subject = 'NTCP';
            } elseif ($userNTCP == 0) {
                $status = 1;
                $subject = 'NNTCP';
            }

            $user->NTCP = $status;
            $user->save();
            return $this->success(true, 'changedUserNTCP', 'عملیات با موفقیت انجام شد.');
        } else {
            return $this->alerts(false, 'changedUserNTCPFailed', 'خطا در انجام عملیات');
        }
    }

    public function ResetPassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $username = $request->input('username');
        $user = User::where('username', $username)->first();
        if ($username and $user) {
            $user->password = bcrypt(12345678);
            $user->NTCP = 1;
            $user->save();
            $subject = 'Password Resetted';
            return $this->success(true, 'passwordResetted', 'عملیات با موفقیت انجام شد.');
        } else {
            return $this->alerts(false, 'resetPasswordFailed', 'خطا در انجام عملیات');
        }
    }

    public function newUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'scientificGroup' => 'required|integer|exists:scientific_groups,id',
            'type' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return $this->alerts(false, 'userFounded', 'نام کاربری تکراری وارد شده است.');
        }
        $name = $request->input('name');
        $family = $request->input('family');
        $username = $request->input('username');
        $password = $request->input('password');
        $type = $request->input('type');
        $scientificGroup = $request->input('scientificGroup');

        $lastUserId = User::orderByDesc('id')->first()->id;

        $user = new User();
        $user->id = $lastUserId + 1;
        $user->name = $name;
        $user->family = $family;
        $user->username = $username;
        $user->password = bcrypt($password);
        if ($type == 5 or $type == 6) {
            $user->scientific_group = $scientificGroup;
        } else {
            $user->scientific_group = null;
        }
        $user->type = $type;
        $user->subject = Role::findById($type)->name;
        $user->adder = auth()->user()->id;
        $user->save();
        $user->assignRole(Role::findById($type)->name);
        return $this->success(true, 'userAdded', 'کاربر با موفقیت تعریف شد. برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $userID = $request->input('userIdForEdit');
        $name = $request->input('editedName');
        $family = $request->input('editedFamily');
        $type = $request->input('editedType');
        $scientificGroup = $request->input('editedScientificGroup');
        $user = User::findOrFail($userID);
        if ($user) {
            $user->name = $name;
            $user->family = $family;
            if ($type == 5 or $type == 6) {
                $user->scientific_group = $scientificGroup;
            } else {
                $user->scientific_group = null;
            }
            $user->type = $type;
            $user->subject = Role::findById($type)->name;
        }
        $user->editor = auth()->user()->id;
        $user->syncRoles(Role::findById($type)->name);
        $user->save();
        return $this->success(true, 'userEdited', 'کاربر با موفقیت ویرایش شد. برای نمایش اطلاعات ویرایش شده، صفحه را رفرش نمایید.');
    }

    public function getUserInfo(Request $request)
    {
        $user = User::findOrFail($request->userID);
        return $user;
    }
}
