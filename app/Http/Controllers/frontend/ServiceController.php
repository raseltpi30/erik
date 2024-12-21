<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function generalCleaning(){
        return view('pages.services.general');
    }
    public function deepCleaning(){
        return view('pages.services.deep');
    }
    public function officeCleaning(){
        return view('pages.services.office');
    }
    public function endLessCleaning(){
        return view('pages.services.end-lease');
    }
    public function organizationHourCleaning(){
        return view('pages.services.organization-hour');
    }
    public function commercialCleaning(){
        return view('pages.services.commercial');
    }
}
