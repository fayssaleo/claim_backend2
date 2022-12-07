<?php

namespace App\Modules\TypeOfEquipment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeOfEquipmentController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("TypeOfEquipment::welcome");
    }
}
