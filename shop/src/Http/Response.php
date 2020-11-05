<?php


namespace App\Http;


class Response
{
    private string $body;
    private array  $headers;
    private int    $statusCode;

    public function __construct(string $body = '', array $headers = [], int $statusCode = 200)
    {
        $this->body = $body;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function send()
    {
        foreach ($this->headers as $header => $value) {
            if ($value) {
                $value = ":" . $value;
            }
            header($header . $value);
        }
        $this->sendStatusCode();
        echo $this->body;
    }

    public function redirect(string $url)
    {
        $this->headers['location'] = $url;
    }

    public function sendStatusCode()
    {
        http_response_code($this->statusCode);
    }

    public function setStatusCode(int $statusCode = 200)
    {
        $this->statusCode = $statusCode;
    }
}