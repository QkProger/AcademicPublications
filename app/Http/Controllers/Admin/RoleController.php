<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/Role/Index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Role/Create');
    }

    public function store(Request $request)
    {
        Role::create([
            'name' => $request->name,
        ]);
        if (Log::log_status()) {
            Log::create([
                'name' => $request->name . ' жаңа рөлін қосты ',
                'tr_name' => $request->name . ' yeni bir rol ekledi ',
                'type' => 2,
                'user_id' => auth()->guard('web')->id(),
            ]);
        }
        return redirect()->route('admin.roles.index')->with('success', 'Сәтті қосылды');
    }

    public function edit(Role $role)
    {
        return Inertia::render('Admin/Role/Edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $current_name = $role->name;
        $role->update([
            'name' => $request->name,
        ]);
        if (Log::log_status()) {
            Log::create([
                'name' => $current_name . ' рөлінің атын ' . $request->name . '-ға ауыстырды',
                'tr_name' => $current_name . ' rol adını ' . $request->name . ' olarak değiştirdi',
                'type' => 3,
                'user_id' => auth()->guard('web')->id(),
            ]);
        }
        return redirect()->route('admin.roles.index')->with('success', 'Сәтті сақталды');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        UserRole::where('role_id', $role->id)->delete();
        if (Log::log_status()) {
            Log::create([
                'name' => $role->name . ' рөлін жойды',
                'tr_name' => $role->name . ' rolünü kaldırdı',
                'type' => 4,
                'user_id' => auth()->guard('web')->id(),
            ]);
        }
        return redirect()->back()->withSuccess('Сәтті жойылды');
    }
}
