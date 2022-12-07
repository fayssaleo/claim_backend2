<?php

namespace App\Modules\Fonction\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FonctionController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Fonction::welcome");
    }
}
