<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\SubscriptionSuccessful;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validate the email
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Check if the email already exists
        $existingSubscriber = Subscribe::where('email', $email)->first();

        if ($existingSubscriber) {
            $notification = array('message' => 'Email already Exist!', 'alert-type' => 'error');
            return redirect()->route('subscribe.thanks')->with($notification);
        } else {
            Mail::to($email)->send(new SubscriptionSuccessful($email));
            $subscribe = Subscribe::create([
                'email' => $email,
                'status' => 'subscribed',
            ]);
            $notification = array('message' => 'Subsribe Successfully!', 'alert-type' => 'success');
            return redirect()->route('subscribe.thanks')->with($notification);
        }
    }
    public function index()
    {
        $placeId = 'ChIJibnoPYBW0iERc57oSdt3QL4'; // Your Place ID
        $apiKey = 'AIzaSyCeWaWnnt7u9wRWZVCUBBekySgdCrVQ_lQ';

        $response = Http::get("https://maps.googleapis.com/maps/api/place/details/json", [
            'place_id' => $placeId,
            'key' => $apiKey,
            'fields' => 'reviews'
        ]);
        $reviews = $response->json()['result']['reviews'] ?? [];
        return view('home', compact('reviews'));
    }
}
