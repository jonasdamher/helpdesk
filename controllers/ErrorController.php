<?php

declare(strict_types=1);

class ErrorController extends Controller
{
    public function error401()
    {
        $code = 401;
        http_response_code($code);
        $message = 'Error ' . $code . ', no está autorizado.';
        Head::title('Error ' . $code);
        include View::render('error');
    }

    public function error404()
    {
        $code = 404;
        http_response_code($code);
        $message = 'Error ' . $code . ', página no encontrada.';
        Head::title('Error ' . $code);
        include View::render('error');
    }

    public function error500()
    {
        $code = 500;
        http_response_code($code);
        $message = 'Error ' . $code . ', hubo un error interno en el servidor.';
        Head::title('Error ' . $code);
        include View::render('error');
    }
}
