<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoPrueba extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('Correo de Prueba')->view('emails.correo_prueba');
    }
}
