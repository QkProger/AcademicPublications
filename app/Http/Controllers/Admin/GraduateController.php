<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CenterCountry;
use App\Models\CenterNationality;
use App\Models\CenterProfession;
use App\Models\Degree;
use App\Models\Graduate;
use App\Models\IcDepartment;
use App\Models\JobplaceType;
use App\Models\OrganizationType;
use App\Models\PaymentForm;
use App\Models\Profession;
use App\Models\StudyForm;
use App\Models\StudyLanguage;
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

    public function edit(Graduate $graduate)
    {
        $studyForms = StudyForm::get();
        $paymentforms = PaymentForm::get();
        $studylanguages = StudyLanguage::get();
        $professions = Profession::get();
        $jobplacetypes = JobplaceType::get();
        $degrees = Degree::get();
        $centerprofessions = CenterProfession::get();
        $centercountries = CenterCountry::get();
        $organizationtypes = OrganizationType::get();
        $icdepartments = IcDepartment::get();
        $center_nationalities = CenterNationality::get();
        $graduate->load('studyForm');
        return Inertia::render('Admin/Graduate/Edit', [
            'graduate' => $graduate,
            'studyForms' => $studyForms,
            'paymentforms' => $paymentforms,
            'studylanguages' => $studylanguages,
            'professions' => $professions,
            'jobplacetypes' => $jobplacetypes,
            'degrees' => $degrees,
            'centerprofessions' => $centerprofessions,
            'centercountries' => $centercountries,
            'organizationtypes' => $organizationtypes,
            'icdepartments' => $icdepartments,
            'center_nationalities' => $center_nationalities,
        ]);
    }

}
