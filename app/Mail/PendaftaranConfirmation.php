<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftar;

class PendaftaranConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftar;

    public function __construct(Pendaftar $pendaftar)
    {
        $this->pendaftar = $pendaftar;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pendaftaran PPDB SMK BaktiNusantara 666')
                    ->view('emails.pendaftaran-confirmation');
    }
}