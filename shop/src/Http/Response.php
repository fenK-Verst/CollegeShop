<?php


namespace App\Http;


class Response
{
    private string $body;
    private array $headers;

    public function __construct(string $body = '', array $headers = [])
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

    /**
     * @throws \Exception
     */
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

    public function redirect(string $url)
    {
        header("Location: $url");
    }
}