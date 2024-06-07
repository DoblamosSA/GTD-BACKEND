<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionSoliCreditoaprobadaasesorMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $nombreSolicitante;
    public $radicado;
   public $valorCreditoOtorgado;
   public $diasPlazo;
  
  

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreSolicitante, $radicado, $valorCreditoOtorgado, $diasPlazo)
    {
        $this->nombreSolicitante = $nombreSolicitante;
        $this->radicado = $radicado;
        $this->valorCreditoOtorgado = $valorCreditoOtorgado;
        $this->diasPlazo = $diasPlazo;
     
    }
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contactenos@doblamos.com', 'Notificación DOBLAMOS')
            ->view('emails.aprobado-cartera-noti-asesor')
            ->subject('Solicitud de crédito aprobada');
    }
}
