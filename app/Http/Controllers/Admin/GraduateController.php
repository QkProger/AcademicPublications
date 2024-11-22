<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CenterCountry;
use App\Models\CenterNationality;
use App\Models\CenterProfession;
use App\Models\Degree;
use App\Models\EmploymentReason;
use App\Models\Graduate;
use App\Models\GrantType;
use App\Models\IcDepartment;
use App\Models\IcType;
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
        $ictypes = IcType::get();
        $granttypes = GrantType::get();
        $graduate->load([
            'studyForm',
            'paymentForm',
            'studyLanguage',
            'profession',
            'jobplaceType',
            'degree',
            'centerProfession',
            'centerCountry',
            'organizationType',
            'icDepartment',
            'centerNationality',
        ]);

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
            'ictypes' => $ictypes,
            'granttypes' => $granttypes,
        ]);
    }

    public function update(Request $request, $id)
    {
        $graduate = Graduate::find($id);



        $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'birthDate' => 'required',
            'sexId' => 'required',
            'studyFormId' => 'required',
            'paymentFormId' => 'required',
            'studyLanguageId' => 'required',
            'professionId' => 'required',
            'startOrderNumber' => 'required',
            'finishOrderNumber' => 'required',
            'finishDocDate' => 'required',
            'degreeId' => 'required',
            'startDate' => 'required',
            'finishOrderDate' => 'required',
            'sitizenshipId' => 'required',
            'protocolDate' => 'required',
            'protocolNumber' => 'required',
            'regDiplomNumber' => 'required',
            'icNumber' => 'required',
            'icDate' => 'required',
            'icDepartmentId' => 'required',
            'nationId' => 'required',
            'education' => 'required',
            'educationalInstitution' => 'required',
            'icType' => 'required',
            'iacDiplomaNumber' => 'required',
            'iacDiplomaSeries' => 'required',
            'awardedacademicdegreekz'=>'required',
            'awardedacademicdegreeru'=>'required',
            'awardedacademicdegreeen'=>'required',
            'awardedqualificationkz'=>'required',
            'awardedqualificationru'=>'required',
            'awardedqualificationen'=>'required',
        ];

        $messages = [
            'firstName'=>'Есім болу міндетті түрде!',
            'lastName'=>'Есім болу міндетті түрде!',
            'birthDate' => 'Туылған күні болу міндетті түрде',
            'sexId' => 'Жынысы болу міндетті түрде',
            'studyFormId' => 'Оқу түрі таңдалу міндетті түрде',
            'paymentFormId' => 'Төлем түрі таңдалу міндетті түрде',
            'studyLanguageId' => 'Оқу тілі болу міндетті түрде',
            'professionId' => 'Мамандық таңдалу міндетті түрде',
            'startOrderNumber' => 'Оқуды бітіру туралы бастау номері болу міндетті түрде',
            'finishOrderNumber' => 'Оқуды бітіру туралы бастау номері болу міндетті түрде',
            'finishDocDate' => 'Бітіру уақыты болу міндетті түрде',
            'degreeId' => 'Академиялық дәреже болу міндетті түрде',
            'startDate' => 'Алғаш оқуға қабылдау күні болу міндетті түрде',
            'finishOrderDate' => 'Оқуды бітіру туралы бұйрық күні болу міндетті түрде',
            'sitizenshipId' => 'Азаматтығы болу міндетті түрде',
            'protocolDate' => 'Протокол күні болу міндетті түрде',
            'protocolNumber' => 'Протокол нөмері болу міндетті түрде',
            'regDiplomNumber' => 'Дипломның тіркеу номері болу міндетті түрде',
            'icNumber' => 'Құжат номері болу міндетті түрде',
            'icDate' => 'Құжаттың берілу күні болу міндетті түрде',
            'icDepartmentId' => 'Құжат берген Мекеме таңдалу міндетті түрде',
            'nationId' => 'Ұлты таңдалу міндетті түрде',
            'education' => 'Талапкердің бітірген оқу орнының атауы болу міндетті түрде',
            'educationalInstitution' => 'Білім беру мекемесін бітірген таңдалу міндетті түрде',
            'icType' => 'Құжат түрі таңдалу міндетті түрде',
            'iacDiplomaNumber' => 'Диплом нөмірі болу міндетті түрде',
            'iacDiplomaSeries' => 'Диплом сериясы болу міндетті түрде',
            'awardedacademicdegreekz'=>'Қазақ тілінде берілген академиялық дәреже болу міндетті түрде',
            'awardedacademicdegreeru'=>'Орыс тілінде берілген академиялық дәреже болу міндетті түрде',
            'awardedacademicdegreeen'=>'Ағылшын тілінде берілген академиялық дәреже болу міндетті түрде',
            'awardedqualificationkz'=>'Қазақ тілінде берілген біліктілік болу міндетті түрде',
            'awardedqualificationru'=>'Орыс тілінде берілген біліктілік болу міндетті түрде',
            'awardedqualificationen'=>'Ағылшын тілінде берілген біліктілік болу міндетті түрде',
        ];

        

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
            'diplomDuplicateIssueDate' => $request->diplomDuplicateIssueDate,
            'nostrificationCertificateDate' => $request->nostrificationCertificateDate,
            'nostrificationCertificateNumber' => $request->nostrificationCertificateNumber,
            'livingAddress' => $request->livingAddress,
            'stateCommissionDecisionDate' => $request->stateCommissionDecisionDate,
            'certificateSeries' => $request->certificateSeries,
            'certificateNumber' => $request->certificateNumber,
            'certificateRegistrationNumber' => $request->certificateRegistrationNumber,
            'certificateIssueDate' => $request->certificateIssueDate,
            'specializationId' => $request->specializationId,
            'isMarried' => $request->isMarried,
            'iacDiplomaNumber' => $request->iacDiplomaNumber,
            'internIacDiplomaSeries' => $request->internIacDiplomaSeries,
            'internIacDiplomaNumber' => $request->internIacDiplomaNumber,
            'internProtocolNumber' => $request->internProtocolNumber,
            'internProtocolDate' => $request->internProtocolDate,
            'internRegistrationNumber' => $request->internRegistrationNumber,
            'internDateOfIssue' => $request->internDateOfIssue,
            'internHonoursDiploma' => $request->internHonoursDiploma,
            'defenseOfDissertationInOtherHpeo' => $request->defenseOfDissertationInOtherHpeo,
            'defenseOfDissertationOtherHpeoId' => $request->defenseOfDissertationOtherHpeoId,
            'dateDissertationDefense' => $request->dateDissertationDefense,
            'awardedacademicdegreekz' => $request->awardedacademicdegreekz,
            'awardedacademicdegreeru' => $request->awardedacademicdegreeru,
            'awardedacademicdegreeen' => $request->awardedacademicdegreeen,
            'awardedqualificationkz' => $request->awardedqualificationkz,
            'awardedqualificationru' => $request->awardedqualificationru,
            'awardedqualificationen' => $request->awardedqualificationen,
            'educationalInstitution' => $request->educationalInstitution,
            'enterExamType' => $request->enterExamType,
        ]);
        $request->validate($rules, $messages);
        

        return redirect()->route('admin.graduates.index')->withSuccess("Сәтті сақталды!");
    }
}
