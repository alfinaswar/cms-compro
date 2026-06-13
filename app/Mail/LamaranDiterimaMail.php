<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\LamaranKerja;
use App\Models\LowonganKerja;

class LamaranDiterimaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lamaran;
    public $lowongan;

    public function __construct(LamaranKerja $lamaran, LowonganKerja $lowongan)
    {
        $this->lamaran = $lamaran;
        $this->lowongan = $lowongan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Lamaran - ' . $this->lowongan->Posisi,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lamaran-diterima',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
