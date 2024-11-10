<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AdminLoginRequest;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    protected $guard = 'web';
    public function adminLoginForm(AdminLoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $lang_code = $request->lang_code;
        $user = User::query()->where('email', $email)->firstOr(function () {
            throw ValidationException::withMessages([
                'email' => [__('Email адрес табылмады')]
            ]);
        });
        if (Hash('sha1', $password) !== $user->password) {
            throw ValidationException::withMessages([
                'password' => [__('Email немеме құпия сөз қате')]
            ]);
        }
        $user->update([
            'lang_code' => $lang_code,
        ]);
        Auth::guard($this->guard)->login($user);

        if (Log::log_status()) {
            Log::create([
                'name' => 'Жүйеге кірді',
                'tr_name' => 'Giriş yaptı',
                'type' => 1,
                'user_id' => auth()->guard('web')->id(),
            ]);
        }
        return redirect()->route('admin.index');
    }

    public function logout()
    {
        $user_id = auth()->guard('web')->id();
        Auth::guard($this->guard)->logout();
        if (Log::log_status()) {
            Log::create([
                'name' => 'Жүйеден шықты',
                'tr_name' => 'Çıkış yaptı',
                'type' => 5,
                'user_id' => $user_id,
            ]);
        }
        return redirect()->route('adminLoginShow');
    }

    public function getUser()
    {
        $user = Auth::user();
        $userRoles = UserRole::where('user_id', $user->id)
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->select('roles.name')
            ->get();
        return response()->json([
            'user' => $user,
            'userRoles' => $userRoles,
        ]);
    }
}
