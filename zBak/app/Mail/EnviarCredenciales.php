<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarCredenciales extends Mailable
{
    use Queueable, SerializesModels;

    public $Pwd;
    public $NombreCompleto;
    public $UName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Pwd,$NombreCompleto,$UName)
    {
        $this->Pwd = $Pwd;
        $this->NombreCompleto = $NombreCompleto;
        $this->UName = $UName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.EnviarCredenciales')
               ->subject('Credenciales de acceso');
    }
}
