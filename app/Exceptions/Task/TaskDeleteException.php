<?php
namespace App\Exceptions\Task;

use Exception;
class TaskDeleteException extends Exception
{
    protected $message = 'Erro ao deletar tarefa';
    protected $code = 400;

    public function __construct($message = null, $code = null)
    {
        parent::__construct($message ?? $this->message, $code ?? $this->code);
    }
}