<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Subscription;
use Stripe\Customer;
use Stripe\Invoice;
use Illuminate\Support\Carbon;

class AdminSubscriptionController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function index()
    {
        // Prepare an array to hold all fetched subscriptions
        $subscriptions = [];
        $hasMore = true;
        $startingAfter = null;

        // Loop to fetch all subscriptions in case of pagination
        while ($hasMore) {
            // Fetch subscriptions with a limit of 100 and status 'all'
            $response = Subscription::all([
                'status' => 'all',  // Fetch all subscriptions regardless of status
                'limit' => 100,     // Fetch 100 subscriptions at a time
                'starting_after' => $startingAfter, // Used for pagination
            ]);

            // Merge the newly fetched subscriptions with the existing ones
            $subscriptions = array_merge($subscriptions, $response->data);

            // Check if more subscriptions need to be fetched
            if ($response->has_more) {
                $startingAfter = end($response->data)->id; // Get the last subscription's ID for pagination
            } else {
                $hasMore = false; // No more subscriptions to fetch
            }
        }

        // Prepare an array to hold subscriptions with customer data
        $subscriptionsWithCustomers = [];

        foreach ($subscriptions as $subscription) {
            // Retrieve the customer information
            $customer = Customer::retrieve($subscription->customer);
            $subscription->customer_name = $customer->name;
            $subscription->customer_email = $customer->email;

            // Get frequency, amount, and other plan details from the subscription items
            if (!empty($subscription->items->data)) {
                $plan = $subscription->items->data[0]->plan; // Assuming a single plan per subscription
                $subscription->amount = $plan->amount / 100; // Amount is in cents, convert to dollars

                $subscription->frequency = $plan->billing_scheme === 'per_unit' ? 'Per Unit' : 'Recurring';
                $subscription->interval = $plan->interval; // e.g., month, year
                $subscription->interval_count = $plan->interval_count; // e.g., 1, 2

                // Calculate the next billing date
                $subscription->next_billing_date = Carbon::createFromTimestamp($subscription->current_period_end)->format('d/m/Y');
            } else {
                // Set default values if no items or plan are available
                $subscription->amount = 'Unknown';
                $subscription->frequency = 'Unknown';
                $subscription->interval = 'Unknown';
                $subscription->interval_count = 'Unknown';
                $subscription->next_billing_date = 'Unknown';
            }

            // Add the subscription with customer data to the array
            $subscriptionsWithCustomers[] = $subscription;
        }

        // Pass the subscriptions with customer data to the view
        return view('admin.subscriptions.index', compact('subscriptionsWithCustomers'));
    }


    public function show($id)
    {
        // Fetch a specific subscription
        $subscription = Subscription::retrieve($id);

        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function update(Request $request, $id)
    {
        // Update subscription (e.g., change the plan)
        $subscription = Subscription::retrieve($id);

        $subscription->items = [['id' => $request->new_price_id]];
        $subscription->save();

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function cancel($id)
    {
        // Cancel the subscription
        $subscription = Subscription::retrieve($id);
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription canceled successfully.');
    }
}
