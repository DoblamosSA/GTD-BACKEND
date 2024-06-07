<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class DocumentosAdjuntosMail extends Mailable  implements ShouldQueue
{
    public $documentos;
    public $nombreSolicitante;
    public $numeroRadicado;
    public $montoaprobado;
    public $montosolicitado;
    public $plazo;
    public $id;
    public $id_usuarioLuisochoa;
  public $comentarioAprobador;


    public function __construct($documentos,$nombreSolicitante,$numeroRadicado,$montoaprobado,$montosolicitado,$plazo,$id,$id_usuarioLuisochoa, $comentarioAprobador)
    {
        $this->documentos = $documentos;
        $this->nombreSolicitante = $nombreSolicitante;
        $this->numeroRadicado = $numeroRadicado;
        $this->montoaprobado = $montoaprobado; 
        $this->montosolicitado=$montosolicitado;
        $this->plazo = $plazo;
        $this->id = $id;
        $this->id_usuarioLuisochoa = $id_usuarioLuisochoa;
       $this->comentarioAprobador =  $comentarioAprobador;
    }






    public function build()
    {
        // Filtrar documentos para eliminar los que no existen o son directorios
        $documentos = array_filter($this->documentos, function ($ruta) {
            return file_exists($ruta) && !is_dir($ruta);
        });
    
        // Log para verificar los documentos que se van a adjuntar
        \Log::info('Adjuntando documentos:', $documentos);
    
        $mail = $this->view('emails.documentos_adjuntos-gerencia')
            ->subject('Aprobación crédito director financiero');
    
        // Adjuntar documentos al correo solo si existen
        foreach ($documentos as $nombre => $ruta) {
            $mail->attach($ruta, ['as' => "{$nombre}.pdf"]);
        }
    
        return $mail;
    }
    
}
