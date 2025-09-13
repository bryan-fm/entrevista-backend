<?php
namespace App\Exceptions\Task;

use Exception;

class TaskNotFoundException extends Exception
{
    protected $message = 'Tarefa não encontrada';
    protected $code = 404;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}