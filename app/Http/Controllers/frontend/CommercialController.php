<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommercialController extends Controller
{
    public function store(Request $request){
        DB::table('commercials')->insert([
            'first_name' => $request->input('first-name'),
            'last_name' => $request->input('last-name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'street' => $request->input('street'),
            'unit' => $request->input('unit'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal-code'),
            'square_footage' => $request->input('square-footage'),
            'number_floors' => $request->input('number-floors'),
            'types_areas' => $request->input('types-areas'),
            'specific_tasks' => $request->input('specific-tasks'),
            'cleaning_frequency' => $request->input('cleaning-frequency'),
            'cleaning_schedule' => $request->input('cleaning-schedule'),
            'access_security' => $request->input('access-security'),
            'additional_services' => $request->input('additional-services'),
            'created_at' => now(),
            'updated_at' => now(),

        ]);
        $notification = array('message' => 'Your Commerical Quote has been submitted!', 'alert-type' => 'success');
        return redirect()->route('qoute.thanks')->with($notification);
    }
}
