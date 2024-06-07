<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\CarteraDoblamos\GestionCartera\Cuentasporpagar;
class EnviosaldospendientesClientesMail  extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $facturas;
    public $sumaSaldoPendiente;
    /**
     * Create a new message instance.
     *
     * @param  Cuentasporpagar  $cuenta
     * @return void
     */
    public function __construct(array $facturas, $sumaSaldoPendiente)
    {
        $this->facturas = $facturas;
        $this->sumaSaldoPendiente = $sumaSaldoPendiente; // Pasa la suma al constructor
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.GestionCartera.TemplateSaldosPendientes')
            ->with(['facturas' => $this->facturas, 'sumaSaldoPendiente' => $this->sumaSaldoPendiente])
            ->subject('Saldos Vencidos Cliente'); // Agrega el asunto aquí
    }
    
}
