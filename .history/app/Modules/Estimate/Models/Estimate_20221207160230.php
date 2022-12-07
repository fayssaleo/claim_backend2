<?php

namespace App\Modules\Estimate\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Modules\Valuation\Models\Valuation;
use App\Modules\Automobile\Models\Automobile;
use App\Modules\Equipment\Models\Equipment;
use App\Modules\Container\Models\Container;
use App\Modules\Vessel\Models\Vessel;
use App\Modules\Estimate\Models\fileEstimates;

class Estimate extends Model
{
    use HasFactory;
    protected $guarded= ["id"];
    protected $table = 'estimates';


    public function automobile()
    {
        return $this->belongsTo(Automobile::class);
    }
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function fileEstimates()
    {
        return $this->hasOne(fileEstimates::class);
    }

    protected $casts = [

        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',

    ];
}
