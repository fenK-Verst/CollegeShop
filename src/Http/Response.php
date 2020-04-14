<?php


namespace App\Http;


class Response
{
    private $body;
    private $headers;

    public function __construct($body, array $headers = [])
    {
        $this->body = $body;
        $this->headers = $headers;
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
            header("$header:$value");
        }
        if (is_null($this->body)) {
            throw new \Exception("invalid body");
        }
        echo $this->body;
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}