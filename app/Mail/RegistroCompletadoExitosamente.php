<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroCompletadoExitosamente extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = "Confirmacion de Registro Estudiante";
    // public $NombreGet = "LUIS";
    // public $UsuarioGet = "LCCH";
    // public $PasswordGet = "12345";
    public $ConjuntoDatos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // ESTA PARTE PODEMOS DEJAR POR DEFECTO SI NO QUEREMOS ENVIAR PARAMETROS O DATOS A NUESTRO 
    // MENSAJE DE CORREO
    public function __construct($datos)
    {
        $this->ConjuntoDatos = $datos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.registrocompleted');
    }
}
