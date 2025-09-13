<?php
namespace App\Exceptions\User;

use Exception;
class UserDeleteException extends Exception
{
    protected $message = 'Erro ao deletar usuário';
    protected $code = 400;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}