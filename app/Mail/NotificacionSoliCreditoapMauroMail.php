<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionSoliCreditoapMauroMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $documentos;
    public $nombreSolicitante;
    public $numeroRadicado;
    public $montoaprobado;
    public $plazo;
    public $id;
    public $id_usuarioMauro;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($documentos,$nombreSolicitante,$numeroRadicado,$montoaprobado,$plazo,$id,$id_usuarioMauro)
    {
        $this->documentos = $documentos;
        $this->nombreSolicitante = $nombreSolicitante;
        $this->numeroRadicado = $numeroRadicado;
        $this->montoaprobado = $montoaprobado;
        $this->plazo = $plazo;
        $this->id = $id;
        $this->id_usuarioMauro = $id_usuarioMauro;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
  
     public function build()
     {
         // Filtrar documentos para eliminar los que no existen o son directorios
         $documentos = array_filter($this->documentos, function ($ruta) {
             return file_exists($ruta) && !is_dir($ruta);
         });
     
         // Log para verificar los documentos que se van a adjuntar
         \Log::info('Adjuntando documentos:', $documentos);
     
         $mail = $this->view('emails.documentos_adjuntos-gerencia-Mauro')
             ->subject('Aprobación crédito beratung');
     
         // Adjuntar documentos al correo solo si existen
         foreach ($documentos as $nombre => $ruta) {
             $mail->attach($ruta, ['as' => "{$nombre}.pdf"]);
         }
     
         return $mail;
     }
     
    }