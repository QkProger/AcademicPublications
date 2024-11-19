<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CenterCountry;
use App\Models\CenterNationality;
use App\Models\CenterProfession;
use App\Models\Degree;
use App\Models\EmploymentReason;
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
use PhpOffice\PhpWord\Writer\Word2007\Part\Rels;

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
        $employmentreasons = EmploymentReason::get();

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
            'employmentreasons' => $employmentreasons,
        ]);
    }

    public function update(Request $request, $id)
    {
        $graduate = Graduate::find($id);
        $graduate->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'patronymic' => $request->patronymic,
            'birthDate' => $request->birthDate,
            'iinPlt' => $request->iinPlt,
            'sexId' => $request->sexId,
            'studyFormId' => $request->studyFormId,
            'paymentFormId' => $request->paymentFormId,
            'studyLanguageId' => $request->studyLanguageId,
            'professionId' => $request->professionId,
            'hasJob' => $request->hasJob,
            'jobPlace' => $request->jobPlace,
            'gpa' => $request->gpa,
            'startOrderNumber' => $request->startOrderNumber,
            'finishOrderNumber' => $request->finishOrderNumber,
            'finishDiplomSeries' => $request->finishDiplomSeries,
            'finishDocDate' => $request->finishDocDate,
            'doctorDefended' => $request->doctorDefended,
            'degreeId' => $request->degreeId,
            'startDate' => $request->startDate,
            'finishOrderDate' => $request->finishOrderDate,
            'finishDiplomNumber' => $request->finishDiplomNumber,
            'centerProfessionCode' => $request->centerProfessionCode,
            'oldUniversityName' => $request->oldUniversityName,
            'phone' => $request->phone,
            'mobilePhone' => $request->mobilePhone,
            'sitizenshipId' => $request->sitizenshipId,
            'firstNameEn' => $request->firstNameEn,
            'lastNameEn' => $request->lastNameEn,
            'patronymicEn' => $request->patronymicEn,
            'organizationType' => $request->organizationType,
            'protocolDate' => $request->protocolDate,
            'protocolNumber' => $request->protocolNumber,
            'regDiplomNumber' => $request->regDiplomNumber,
            'studentId' => $request->studentId,
            'icNumber' => $request->icNumber,
            'icDate' => $request->icDate,
            'icDepartment' => $request->icDepartment,
            'nationId' => $request->nationId,
            'entCertDatePrint' => $request->entCertDatePrint,
            'certificate' => $request->certificate,
            'rating' => $request->rating,
            'education' => $request->education,
            'jobPlaceTypeId' => $request->jobPlaceTypeId,
            'employmentReasonId' => $request->employmentReasonId,
        ]);

        return redirect()->route('admin.graduates.index')->withSuccess("Сәтті сақталды!");
    }
}
