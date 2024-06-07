<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionSoliCreditonuevacarteraMail  extends Mailable implements ShouldQueue
{
  
        use Queueable, SerializesModels;
    
        public $nombreSolicitante;
        public $nit;
        public $montoSolicitado;
        public $plazoCreditoMeses;
        public $aceptacionPolitica;
        public $radicado;
      
    
    
        public function __construct(
            $nombreSolicitante,
            $nit,
            $montoSolicitado,
            $plazoCreditoMeses,
            $aceptacionPolitica,
            $radicado,
           
        ) {
            $this->nombreSolicitante = $nombreSolicitante;
            $this->nit = $nit;
            $this->montoSolicitado = $montoSolicitado;
            $this->plazoCreditoMeses = $plazoCreditoMeses;
            $this->aceptacionPolitica = $aceptacionPolitica;
            $this->radicado = $radicado;
    
        }
        
    
        public function build()
        {
            return $this->from('contactenos@doblamos.com', 'Notificación DOBLAMOS')
                ->view('emails.Notificacion-soli-cred-cartera-sagrila')
                ->subject('Notificación de Solicitud de Crédito Cliente');
               
                
        }
}
