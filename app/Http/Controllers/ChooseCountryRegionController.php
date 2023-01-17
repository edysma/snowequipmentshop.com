<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChooseCountryRegionController extends Controller
{
    public function index(){
        return view('choose-country-region');
    }
}
