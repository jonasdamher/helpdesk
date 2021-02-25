<?php

declare(strict_types=1);

/**
 * Controlador para vistas.
 */
class Controller extends BaseController
{
    private $responseMessage;

    // GET & SET
    public function getResponseMessage(): string
    {
        $text = '';
        if (is_array($this->responseMessage)) {
            foreach ($this->responseMessage as $value) {
                $text = $text . '<p class="p text-red text-bold pd-t-1">' . $value . '</p>';
            }
        } else {
            $text = '<p class="p text-red text-bold pd-t-1">' . $this->responseMessage . '</p>';
        }
        return $text;
    }

    protected function setResponseMessage($message): void
    {
        $this->responseMessage = $message;
    }

    // OTHERS METHODS

    protected function submitForm(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function updateStatus(): bool
    {
        $status = Utils::getCheck('status');

        $action = $_GET['action'] ?? '';
        switch ($action) {
            case 'new':
                $succesful = 'creado';
                $error = 'crear';
                break;
            case 'update':
                $succesful = 'actualizado';
                $error = 'actualizar';
                break;
        }

        if ($status) {
            switch ($status) {
                case 1:
                    $this->setResponseMessage('Se ha ' . $succesful . ' correctamente.');
                    break;
                case 0:
                    $this->setResponseMessage('Hubo un error al ' . $error . '.');
                    break;
            }
            return true;
        }

        return false;
    }
}
