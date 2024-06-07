<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionSoliCreditoaprobadapersoGerenciaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $nombreSolicitante;
    public $numeroRadicado;
    public $montoaprobado;
    public $plazo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreSolicitante,$numeroRadicado,$montoaprobado,$plazo)
    {
        $this->nombreSolicitante = $nombreSolicitante;
        $this->numeroRadicado = $numeroRadicado;
        $this->montoaprobado = $montoaprobado;
        $this->plazo = $plazo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contactenos@doblamos.com', 'Solicitud de crédito aprobada por gerencia')
            ->view('emails.Notificacion-Gerencia-aprobo')
            ->subject('Solicitud de crédito aprobada por gerencia');
    }
}
