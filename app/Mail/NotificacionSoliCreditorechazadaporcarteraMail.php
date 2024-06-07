<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionSoliCreditorechazadaporcarteraMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $nombreSolicitante;
    public $radicado;
    public $comentariocliente;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreSolicitante, $radicado,$comentariocliente)
    {
        $this->nombreSolicitante = $nombreSolicitante;
        $this->radicado = $radicado;
        $this->comentariocliente = $comentariocliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contactenos@doblamos.com', 'Notificación CRM-DOBLAMOS')
            ->view('emails.solicitud-rechazada-por-cartera-cliente')
            ->subject('Solicitud de crédito Rechazada');
    }
}
