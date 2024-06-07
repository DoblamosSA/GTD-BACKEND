<?php

namespace App\Mail\AprobacionesSolicitudesCompra;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\SolicitudesCreditoAprobaciones;

class EnviarSolicitudAprobaciónCompraMail extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $detalles;
    public $idUsuarioAprobador;

    /**
     * Create a new message instance.
     *
     * @param SolicitudesCreditoAprobaciones $solicitud
     * @param int $idUsuarioAprobador
     * @return void
     */
    public function __construct(SolicitudesCreditoAprobaciones $solicitud, $idUsuarioAprobador)
    {
        $this->solicitud = $solicitud;
        $this->detalles = $solicitud->detalles;  // Cargar los detalles usando la relación
        $this->idUsuarioAprobador = $idUsuarioAprobador;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.NotificacionSolicitudesCompra.SolicitudAprobacionNotificacion')
            ->subject('Solicitud de Aprobación de Compra')
            ->with(['solicitud' => $this->solicitud, 'detalles' => $this->detalles, 'idUsuarioAprobador' => $this->idUsuarioAprobador]);
    }
}
