<?php
namespace App\Exceptions\Task;

use Exception;

class TaskCreationException extends Exception
{
    protected $message = 'Erro ao criar tarefa';
    protected $code = 400;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}
