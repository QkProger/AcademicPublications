<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $iin = $request->iin;
        $name = $request->name;
        $second_name = $request->second_name;
        $surname = $request->surname;

        $users = User::with('roles')
            ->when($id, fn($q) => $q->where('id', $id))
            ->when($iin, fn($q) => $q->where('iin', 'like', "%$iin%"))
            ->when($name, fn($q) => $q->where('name', 'like', "%$name%"))
            ->when($second_name, fn($q) => $q->where('second_name', 'like', "%$second_name%"))
            ->when($surname, fn($q) => $q->where('surname', 'like', "%$surname%"))
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/User/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::get();
        return Inertia::render('Admin/User/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $roles = $request->selectedRoles;
        $user = User::create([
            'name' => $request->name,
            'second_name' => $request->second_name,
            'surname' => $request->surname,
            'fio' => $request->surname . ' ' . $request->second_name . ' ' . $request->name,
            'phone' => $request->phone,
            'iin' => $request->iin,
            'email' => $request->email,
            'job' => $request->job,
            'password' => Hash('sha1', $request->real_password),
            'real_password' => $request->real_password,
            'is_active' => 1,
        ]);
        $user->roles()->attach($roles);

        if (Log::log_status()) {
            Log::create([
                'name' => $request->surname . ' ' . $request->second_name . ' ' . $request->name . ' жаңа қызметкерін қосты',
                'tr_name' => $request->surname . ' ' . $request->second_name . ' ' . $request->name . ' yeni bir çalışan ekledi',
                'type' => 2,
                'user_id' => auth()->guard('web')->id(),
            ]);
        }
        return redirect()->route('admin.users.index')->with('success', 'Сәтті қосылды');
    }

    public function edit(User $user)
    {
        $userRoles = UserRole::where('user_id', $user->id)
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->select('roles.id as id', 'roles.name')
            ->get();
        $roles = Role::get();
        return Inertia::render('Admin/User/Edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $current_user_fio = $user->fio;
        $user->update([
            'name' => $request->name,
            'second_name' => $request->second_name,
            'surname' => $request->surname,
            'fio' => $request->surname . ' ' . $request->second_name . ' ' . $request->name,
            'phone' => $request->phone,
            'iin' => $request->iin,
            'email' => $request->email,
            'job' => $request->job,
            'password' => Hash('sha1', $request->real_password),
            'real_password' => $request->real_password,
            'is_active' => $request->is_active ? 1 : 0,
        ]);
        $roles = $request->selectedRoles;
        $user->roles()->sync($roles);

        $log_text1 = $current_user_fio . ' қызметкерінің аты-жөнін ' . $user->fio . ' қылып ауыстырды';
        $log_tr_text1 = $current_user_fio . ' çalışanı fionun ' . $user->fio . 'ı değiştirdi';
        $log_text2 = $current_user_fio . ' қызметкерінің ақпараттарын өзгертті';
        $log_tr_text2 = $current_user_fio . ' çalışan bilgilerini değiştirdi';
        if (Log::log_status()) {
            Log::create([
                'name' => $current_user_fio == $user->fio ? $log_text2 : $log_text1,
                'tr_name' => $current_user_fio == $user->fio ? $log_tr_text2 : $log_tr_text1,
                'type' => 3,
                'user_id' => auth()->guard('web')->id(),
            ]);
        }
        return redirect()->route('admin.users.index')->withSuccess("Сәтті сақталды!");
    }

    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
        if (Log::log_status()) {
            Log::create([
                'name' => $user->fio . ' қызметкерін жойды',
                'tr_name' => $user->fio . 'in çalışanını silmiş',
                'type' => 4,
                'user_id' => auth()->guard('web')->id(),
            ]);
        }
        return redirect()->back()->withSuccess('Сәтті жойылды');
    }

    public function changeLangCode(Request $request, $id)
    {
        User::find($id)->update([
            'lang_code' => $request->lang_code
        ]);
    }
}
