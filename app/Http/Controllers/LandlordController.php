<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandlordController extends Controller
{
    public function index()
    {
        return view('dashboard.landlord'); // Make sure this view exists
    }
}
