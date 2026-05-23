<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverServiceController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('client.driver_service');
    }
}