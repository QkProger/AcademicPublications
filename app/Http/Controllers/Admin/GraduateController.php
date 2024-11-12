<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GraduateController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $iinPlt = $request->iin;
        $firstName = $request->name;
        $patronymic = $request->second_name;
        $lastName = $request->surname;
        $finishOrderDate = $request->finishYear;

        $graduates = Graduate::when($id, fn($q) => $q->where('id', $id))
            ->when($iinPlt, fn($q) => $q->where('iinPlt', 'like', "%$iinPlt%"))
            ->when($firstName, fn($q) => $q->where('firstName', 'like', "%$firstName%"))
            ->when($lastName, fn($q) => $q->where('lastName', 'like', "%$lastName%"))
            ->when($patronymic, fn($q) => $q->where('patronymic', 'like', "%$patronymic%"))
            ->when($finishOrderDate, fn($q) => $q->whereYear('finishOrderDate', $finishOrderDate))
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/Graduate/Index', [
            'graduates' => $graduates
        ]);
    }

}
