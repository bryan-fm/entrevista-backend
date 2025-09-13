<?php
namespace App\Exceptions\User;

use Exception;

class UserUpdateException extends Exception
{
    protected $message = 'Erro ao atualizar usuário';
    protected $code = 400;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}