<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $fio = $request->fio;
        $type_id = $request->type_id;
        $logs = Log::with('user')
            ->when($fio, fn ($q) => $q->whereHas('user', fn ($q) => $q->where('fio', 'like', "%$fio%")))
            ->when($type_id, fn ($q) => $q->where('type', $type_id))
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));

        $log = new Log();
        $types = $log->types();
        return Inertia::render('Admin/Log/Index', [
            'logs' => $logs,
            'log_status' => Log::log_status(),
            'types' => $types,
        ]);
    }

    public function changeLogStatus()
    {
        $site_setting = SiteSetting::first();
        $site_setting->update([
            'log_status' => $site_setting->log_status == 1 ? 0 : 1
        ]);

        return redirect()->back()->withSuccess('Логтау статусы ауыстырылды!');
    }
}
