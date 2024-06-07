<?php

namespace App\Mail\AprobacionesSolicitudesCompra;

use App\Models\SolicitudesCreditoAprobaciones;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarNotificacionSolicitudAprobadaMail extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $estado;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SolicitudesCreditoAprobaciones $solicitud, $estado)
    {
        $this->solicitud = $solicitud;
        $this->estado = $estado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = ($this->estado === 'Aprobada') ? 'Solicitud Aprobada' : 'Solicitud Rechazada';

        return $this->view('emails.NotificacionSolicitudesCompra.AprobacionExitosa')
            ->subject($subject);
    }
}
