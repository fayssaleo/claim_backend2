<?php

namespace App\Modules\Vessel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Modules\ShippingLine\Models\ShippingLine;
use App\Modules\TypeOfEquipment\Models\TypeOfEquipment;
use App\Modules\Department\Models\Department;
use App\Modules\NatureOfDamage\Models\NatureOfDamage;
use App\Modules\Estimate\Models\Estimate;

class Vessel extends Model
{
    use HasFactory;

    protected $guarded= ["id"];

    public function typeOfEquipment()
    {
        return $this->belongsTo(TypeOfEquipment::class);
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
    public function shippingLine()
    {
        return $this->belongsTo(ShippingLine::class);
    }
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
        'incident_date' => 'datetime:d/m/Y H:i',
        'claim_date' => 'datetime:d/m/Y H:i',
        'date_of_reimbursement' => 'datetime:d/m/Y H:i',
        'date_of_declaration' => 'datetime:d/m/Y H:i',
        'date_of_feedback' => 'datetime:d/m/Y H:i',
    ];
}
