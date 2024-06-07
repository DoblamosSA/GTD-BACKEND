<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstadosSolicitudCreditoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $nombreSolicitante;
    public $numeroRadicado; // Agrega la variable $numeroRadicado
    public $valorCreditoOtorgado; // Agrega la variable $valorCreditoOtorgado
    public $diasPlazo; // Agrega la variable $diasPlazo
    public $formaPago; // Agrega la variable $formaPago

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($solicitud, $nombreSolicitante, $numeroRadicado, $valorCreditoOtorgado, $diasPlazo, $formaPago)
    {
        $this->solicitud = $solicitud;
        $this->nombreSolicitante = $nombreSolicitante;
        $this->numeroRadicado = $numeroRadicado;
        $this->valorCreditoOtorgado = $valorCreditoOtorgado;
        $this->diasPlazo = $diasPlazo;
        $this->formaPago = $formaPago;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.solicitud-aprobada')
            ->subject('Solicitud de Crédito Aprobada')
            ->with([
                'valorCreditoOtorgado' => $this->valorCreditoOtorgado,
                'diasPlazo' => $this->diasPlazo,
                'formaPago' => $this->formaPago,
            ]);
    }



    
}

