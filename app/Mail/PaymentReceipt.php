<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $userPoints;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, int $userPoints = 0)
    {
        $this->order = $order;
        $this->userPoints = $userPoints;
    }

    /**
     * Get the message envelope.
     */

    public function build()
{
    $pdf = Pdf::loadView('pdf.receipt', [
        'order' => $this->order,
        'userPoints' => $this->userPoints,
    ])->setPaper('A4', 'portrait')->output();

    return $this->subject('🧾 Your Laundry Payment Receipt')
        ->view('emails.payment_receipt')
        ->with([
            'order' => $this->order,
            'userPoints' => $this->userPoints,
        ])
        ->attachData($pdf, 'dobipulse_receipt_' . $this->order->id . '.pdf', [
            'mime' => 'application/pdf',
        ]);
}

}
