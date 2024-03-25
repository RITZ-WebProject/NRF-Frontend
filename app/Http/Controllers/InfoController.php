<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Gallery;
use Illuminate\Http\Request;

class InfoController extends Controller
{
	
    public function gallery()
    {
    $photos = Gallery::all();
    return view('info.gallary', compact('photos'));
     }

    public function showDates()
    {
    $careers = Career::all();
    return view('info.career', compact('careers'));
    }
}
