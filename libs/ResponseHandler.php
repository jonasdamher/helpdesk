<?php

declare(strict_types=1);

class ResponseHandler
{

    private array $response = [
        'valid' => true,
        'message' => '',
        'result' => null,
        'errors' => [],
        'status' => 200
    ];

    public function status(int $status): object
    {
        $this->response['status'] = $status;
        return $this;
    }

    public function success($result, string $message = ''): void
    {
        $this->response['result'] = $result;
        $this->response['message'] = $message;
    }

    public function error(string $error = ''): void
    {
        $this->response['result'] = null;
        $this->response['valid'] = false;
        $this->response['errors'] = $error;
    }

    public function fail(string $message = ''): void
    {
        $this->response['result'] = null;
        $this->response['valid'] = false;
        $this->response['message'] = $message;
    }

    public function send(): array
    {
        return $this->response;
    }
}
