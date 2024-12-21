<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribe;

class SubscribeController extends Controller
{
    public function index()
    {
        $subscribe = Subscribe::all();
        return view('admin.subscribe', compact('subscribe'));
    }
    public function destroy($id){
        $contact = Subscribe::findOrFail($id);
        $contact->delete();
        $notification = array('message' => 'Subscribe Deleted Successfully!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
