<?php

declare(strict_types=1);

class ErrorHandler
{
    public static function response(int $code): void
    {

        http_response_code($code);

        switch ($code) {
            case 401:
                $text = 'No está autorizado';
                break;
            case 404:
                $text = 'Página no encontrada';
                break;
            case 500:
                $text = 'Hubo un error interno en el servidor';
                break;
        }

        $message = 'Error ' . $code . ', ' . $text . '.';
        include View::render('error');
    }
}
