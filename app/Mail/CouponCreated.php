<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class CouponCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $coupon;
    public $email;
    public $discountPercent;
    public $valid_date;

    public function __construct($coupon, $email, $discountPercent, $valid_date)
    {
        $this->email = $email;
        $this->coupon = $coupon;
        $this->discountPercent = $discountPercent;
        $this->valid_date = $valid_date;
    }

    public function build()
    {
        return $this->view('emails.coupon_created') // Create this view
            ->subject("Welcome to Crystal Clean Sydney! Here's Your Exclusive Discount!")
            ->with([
                'coupon' => $this->coupon,
                'discountPercent' => $this->discountPercent,
                'valid_date' => $this->valid_date,
                'email' => $this->email,
            ]);
    }
}
