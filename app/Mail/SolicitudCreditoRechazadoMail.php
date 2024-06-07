<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudCreditoRechazadoMail extends Mailable implements ShouldQueue
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
        return $this->from('contactenos@doblamos.com', 'Notificación CRM-DOBLAMOS')
            ->view('emails.solicitud-rechazada')
            ->subject('Solicitud de crédito Rechazada');
    }
}

