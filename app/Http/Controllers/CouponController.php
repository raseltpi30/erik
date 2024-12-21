<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CouponCreated;

class CouponController extends Controller
{
    public function customCoupon(Request $request)
    {
        // Get tomorrow's date
        $tomorrow = Carbon::tomorrow()->toDateString();
        Mail::to($request->email)->send(new CouponCreated($request->coupon, $request->email, $request->discountPercent, $tomorrow));
        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully! Your Coupon is "' . $request->coupon . '"!'
        ]);

    }
}
