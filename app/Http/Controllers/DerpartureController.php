<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Departure;

class DerpartureController extends Controller
{
    public function create(Request $request)
    {
    	$departure = new Departure();

    	$departure->title = $request->title;

    	$departure->save();
    }
}
