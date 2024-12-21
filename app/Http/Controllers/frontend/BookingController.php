<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentDetailsMail;
use App\Mail\PaymentNotificationEmail;
use Illuminate\Support\Carbon;
use Stripe\Product;
use Stripe\Price;
use Stripe\Customer;
use Stripe\Subscription;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');
        // Check if there's any existing booking for today with the same email (regardless of coupon)
        $existingBookingWithCoupon = DB::table('bookings')
            ->where('email', $request->email)
            ->where('couponDiscountCode', $request->couponDiscountCode)
            ->first();

        // Check if there's any existing booking for today with the same email (regardless of coupon)
        $existingBookingWithEmail = DB::table('bookings')
            ->where('email', $request->email)
            ->where('day', $request->day)
            ->first();

        if ($existingBookingWithCoupon) {
            return response()->json(['message' => "You can't use this discount code again because you've already applied it!"], 400);
        } elseif ($existingBookingWithEmail) {
            return response()->json(['message' => 'You already have a booking on this date. Please pick a different date!'], 400);
        } else {
            // Validate the request data

            $validatedData = $request->validate([
                'finalTotal' => 'required|numeric',
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'email' => 'required|email',
                'phone' => 'nullable|string',
                'street' => 'nullable|string',
                'apt' => 'nullable|string',
                'city' => 'nullable|string',
                'postalCode' => 'nullable|string',
                'service' => 'nullable|string',
                'bathroom' => 'nullable|string',
                'typeOfService' => 'nullable|string',
                'storey' => 'nullable|string',
                'frequency' => 'nullable|string',
                'day' => 'nullable|string',
                'time' => 'nullable|string',
                'discountPercentage' => 'nullable|numeric',
                'discountAmount' => 'nullable|numeric',
                'couponDiscountAmount' => 'nullable|numeric',
                'extras' => 'nullable|array',
                'totalExtras' => 'nullable|numeric',
            ]);
            // for metadata
            $metadata = [
                'Full Name' => $validatedData['firstName'] . ' ' . $validatedData['lastName'],
                'Email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'Address' => $validatedData['street'] . ',' . $validatedData['apt'] . ',' . $validatedData['city'] . ',' . $validatedData['postalCode'],
                'Service' => $validatedData['service'],
                'Bathroom' => $validatedData['bathroom'],
                'Type Of Service' => $validatedData['typeOfService'],
                'Storey' => $validatedData['storey'],
                'Frequency' => $validatedData['frequency'],
                'Day' => $validatedData['day'],
                'Time' => $validatedData['time'],
                'extras' => json_encode($validatedData['extras'] ?? null),
                'Total Extras' => '$' . ($validatedData['totalExtras'] ?? null),
                'FinalTotal' => '$' . $validatedData['finalTotal'],
            ];
            // Stripe::setApiKey('sk_test_51Pg0xxIpCrzhTk3nRAASulLvCNw1F6cry0qmQjejIx7XLUCb5UcD6IF3JlW32GuwTQYV6OqAbDzPxEIGWKKl9aGJ002aMwhWc2');
            Stripe::setApiKey(env('STRIPE_SECRET'));
            // for stripe
            if ($request->frequency == 'week' || $request->frequency == 'month' || $request->frequency == 'fortnight') {
                // Determine the interval and interval_count based on frequency
                $interval = $request->frequency == 'fortnight' ? 'week' : $request->frequency;
                $interval_count = ($request->frequency == 'fortnight') ? 2 : 1;
                $request->validate([
                    'paymentMethodId' => 'required|string',
                ]);
                try {
                    // Create a product dynamically
                    // Create a product dynamically
                    $product = Product::create([
                        'name' => $request->firstName,
                        'metadata' => $metadata,
                    ]);

                    // Create a price for the product
                    $price = Price::create([
                        'unit_amount' => $request->finalTotal * 100,
                        'currency' => 'aud',
                        'recurring' => [
                            'interval' => $interval,
                            'interval_count' => $interval_count,
                        ],
                        'product' => $product->id,
                        'metadata' => $metadata,
                    ]);

                    // Create a customer with the provided email
                    $customer = Customer::create([
                        'payment_method' => $request->paymentMethodId,
                        'email' => $request->email,
                        'name' => $request->firstName . ' ' . $request->lastName,
                        'metadata' => $metadata,
                    ]);

                    // Create a subscription with the created price
                    $subscription = Subscription::create([
                        'customer' => $customer->id,
                        'items' => [[
                            'price' => $price->id,
                        ]],
                        'default_payment_method' => $request->paymentMethodId,
                        'metadata' => $metadata,
                    ]);
                } catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            } else {
                $amount = floatval($request->finalTotal) * 100; // Convert to cents

                // Create a PaymentIntent
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $amount,
                    'currency' => 'aud',
                    'payment_method' => $request->paymentMethodId, // Use PaymentMethodId
                    'confirm' => true, // Automatically confirm the payment
                    'description' => 'One Time Payment for service',
                    'metadata' => $metadata,
                    'automatic_payment_methods' => [
                        'enabled' => true, // Enable automatic payment methods
                    ],
                    'return_url' => 'https://google.com/return-url',
                ]);
            }
            // // for gmail
            // for mail
            Mail::to($validatedData['email'])->send(new PaymentDetailsMail($validatedData));
            // Mail::to('info.crystalcleansyd@gmail.com')->send(new PaymentNotificationEmail($validatedData));
            // for booking in database
            $bookingId = DB::table('bookings')->insertGetId([
                'firstName' => $validatedData['firstName'],
                'lastName' => $validatedData['lastName'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'street' => $validatedData['street'],
                'apt' => $validatedData['apt'],
                'city' => $validatedData['city'],
                'postal_code' => $validatedData['postalCode'],
                'service' => $validatedData['service'],
                'bathroom' => $validatedData['bathroom'],
                'typeOfService' => $validatedData['typeOfService'],
                'storey' => $validatedData['storey'],
                'frequency' => $validatedData['frequency'],
                'day' => $validatedData['day'],
                'time' => $validatedData['time'],
                'discountPercentage' => $validatedData['discountPercentage'] ?? 0,
                'discountAmount' => $validatedData['discountAmount'] ?? 0,
                'couponDiscountCode' => $request->couponDiscountCode ?? 0,
                'couponDiscountAmount' => $validatedData['couponDiscountAmount'] ?? 0,
                'extras' => json_encode($validatedData['extras'] ?? []),
                'totalExtras' => $validatedData['totalExtras'] ?? 0,
                'finalTotal' => $validatedData['finalTotal'],
                'stripe_checkout_session_id' => $request->paymentMethodId,
                'status' => 'processing',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['success' => true, 'Booking' => $bookingId]);
        }
    }
}
