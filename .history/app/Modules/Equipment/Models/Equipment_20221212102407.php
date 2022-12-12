<?php

namespace App\Modules\Equipment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Modules\TypeOfEquipment\Models\TypeOfEquipment;
use App\Modules\Brand\Models\Brand;
use App\Modules\Department\Models\Department;
use App\Modules\NatureOfDamage\Models\NatureOfDamage;
use App\Modules\Claim\Models\Claim;
use App\Modules\Estimate\Models\Estimate;


class Equipment extends Model
{
    use HasFactory;

    protected $guarded= ["id"];

    public function typeOfEquipment()
    {
        return $this->belongsTo(TypeOfEquipment::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function natureOfDamage()
    {
        return $this->belongsTo(NatureOfDamage::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    public function estimate()
    {
        return $this->hasMany(Estimate::class);
    }

    protected $casts = [
        'created_at' => 'datetime:m/d/Y H:i',
        'updated_at' => 'datetime:m/d/Y H:i',
        'incident_date' => 'datetime:m/d/Y',
        'claim_date' => 'datetime:m/d/Y',
        'date_of_reimbursement' => 'datetime:m/d/Y',
        'date_of_declaration' => 'datetime:m/d/Y',
        'date_of_feedback' => 'datetime:m/d/Y',
    ];

}
