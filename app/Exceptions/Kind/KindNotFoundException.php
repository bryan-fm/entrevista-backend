<?php
namespace App\Exceptions\Kind;

use Exception;

class KindNotFoundException extends Exception
{
    protected $message = 'Tipo não encontrado';
    protected $code = 404;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}