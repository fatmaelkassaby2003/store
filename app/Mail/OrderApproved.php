<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $otp;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject("تأكيد طلبك رقم #{$this->order->id}")
                    ->markdown('emails.order.approved');
    }
}
