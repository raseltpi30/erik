<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    // Store contact form submission
    public function store(Request $request)
    {
        // Validate and create a new contact
        $contact = Contact::create($request->only('name', 'email', 'subject', 'message'));
        $notification = array('message' => 'Your inquiry has been submitted.!', 'alert-type' => 'success');
        return redirect()->route('contact.thanks')->with($notification);
    }

    // Show contacts in admin panel
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contact', compact('contacts'));
    }
    public function destroy($id){
        $contact = Contact::findOrFail($id);
        $contact->delete();
        $notification = array('message' => 'Contact Deleted Successfully!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function commercial()
    {
        $commercial = DB::table('commercials')->get();
        return view('admin.commercial.index', compact('commercial'));
    }
    public function commercialDetails($id)
    {
        $item = DB::table('commercials')->where('id', $id)->first();
        return view('admin.commercial.details', compact('item'));
    }
    public function destroyCommercial($id){
        DB::table('commercials')->where('id', $id)->delete();
        $notification = array('message' => 'Commercial Qoutes Deleted Successfully!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
