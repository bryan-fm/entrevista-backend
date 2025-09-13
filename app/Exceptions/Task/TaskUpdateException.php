<?php
namespace App\Exceptions\Task;

use Exception;

class TaskUpdateException extends Exception
{
    protected $message = 'Erro ao atualizar tarefa';
    protected $code = 400;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}