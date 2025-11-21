<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftar;

class StatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftar;
    public $oldStatus;
    public $newStatus;

    public function __construct(Pendaftar $pendaftar, $oldStatus, $newStatus)
    {
        $this->pendaftar = $pendaftar;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        return $this->subject('Update Status Pendaftaran PPDB SMK BaktiNusantara 666')
                    ->view('emails.status-update');
    }
}