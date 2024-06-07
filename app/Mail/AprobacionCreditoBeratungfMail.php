<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AprobacionCreditoBeratungfMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $nombreSolicitante;
    public $radicado;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreSolicitante, $radicado)
    {
        $this->nombreSolicitante = $nombreSolicitante;
        $this->radicado = $radicado;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contactenos@doblamos.com', 'Notificación DOBLAMOS')
            ->view('emails.aprobada-beratung')
            ->subject('Solicitud de crédito aprobada por Beratung');
           
    }
}
