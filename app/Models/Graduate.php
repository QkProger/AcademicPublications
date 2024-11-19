<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graduate extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'graduates';

    public function studyForm()
    {
        return $this->belongsTo(StudyForm::class, 'studyFormId', 'id');
    }
    public function paymentForm()
    {
        return $this->belongsTo(PaymentForm::class, 'paymentFormId', 'id');
    }

    public function studyLanguage()
    {
        return $this->belongsTo(StudyLanguage::class, 'studyLanguageId', 'id');
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class, 'professionId', 'id');
    }

    public function jobplaceType()
    {
        return $this->belongsTo(JobplaceType::class, 'jobPlace', 'id');
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degreeId', 'id');
    }

    public function centerProfession()
    {
        return $this->belongsTo(CenterProfession::class, 'centerProfessionCode', 'id');
    }

    public function centerCountry()
    {
        return $this->belongsTo(CenterCountry::class, 'sitizenshipId', 'id');
    }

    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class, 'organizationType', 'id');
    }

    public function icDepartment()
    {
        return $this->belongsTo(IcDepartment::class, 'icDepartment', 'id');
    }

    public function centerNationality()
    {
        return $this->belongsTo(CenterNationality::class, 'nationId', 'id');
    }
}
