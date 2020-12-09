<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index()
    {

        $sectors = Sector::all();

        return view('sectors.index', compact('sectors'));
    }

}
