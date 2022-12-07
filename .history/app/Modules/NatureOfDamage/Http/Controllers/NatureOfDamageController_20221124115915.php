<?php

namespace App\Modules\NatureOfDamage\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NatureOfDamageController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("NatureOfDamage::welcome");
    }
}
