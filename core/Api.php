<?php

declare(strict_types=1);

/**
 * Controlador para API.
 */
class Api extends BaseController
{

    private $response = [];

    protected function post()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('El método de la petición no coincide.');
            }
        } catch (Exception $e) {
        }
    }

    protected function put()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
                throw new Exception('El método de la petición no coincide.');
            }
        } catch (Exception $e) {
        }
    }

    protected function get()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'GET') {
                throw new Exception('El método de la petición no coincide.');
            }
        } catch (Exception $e) {
        }
    }

    protected function patch()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'PATCH') {
                throw new Exception('El método de la petición no coincide.');
            }
        } catch (Exception $e) {
        }
    }

    protected function delete()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
                throw new Exception('El método de la petición no coincide.');
            }
        } catch (Exception $e) {
        }
    }
}
