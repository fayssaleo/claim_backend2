<?php

namespace App\Modules\Equipment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Modules\TypeOfEquipment\Models\TypeOfEquipment;
use App\Modules\Brand\Models\Brand;
use App\Modules\Department\Models\Department;
use App\Modules\NatureOfDamage\Models\NatureOfDamage;
use App\Modules\Claim\Models\Claim;



class Equipment extends Model
{
    use HasFactory;

    protected $fillable= ["id"];

    public function typeOfEquipment()
    {
        return $this->belongsTo(TypeOfEquipment::class);
    }

    public function Brand()
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

    public function claim()
    {
        return $this->hasOne(Claim::class);
    }

}
