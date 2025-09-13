<?php
namespace App\Exceptions\Kind;

use Exception;

class KindCreationException extends Exception
{
    protected $message = 'Erro ao criar tipo';
    protected $code = 400;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}
