<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\BulkOrder;


class BulkOrderReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
public $order;

public function __construct(BulkOrder $order)
{
    $this->order = $order;
}

public function build()
{
    return $this->subject('Your Bulk Order Receipt')
                ->markdown('emails.bulk.receipt')
                ->with(['order' => $this->order]);
}
}
