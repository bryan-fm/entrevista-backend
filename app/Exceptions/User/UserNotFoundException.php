<?php
namespace App\Exceptions\User;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'Usuário não encontrado';
    protected $code = 404;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}