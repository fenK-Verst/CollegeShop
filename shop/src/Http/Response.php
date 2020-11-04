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


    public function send()
    {
        foreach ($this->headers as $header => $value) {
            if ($value){
                $value = ":".$value;
            }
            header($header.$value);
        }
        echo $this->body;
    }

    public function redirect(string $url)
    {
        $this->headers['location'] = $url;//"Location: $url");
    }
}