<?php

namespace App\Http;
class Request
{
    private string $url;
    public function __construct()
    {
        $this->parseUrl();
    }

    private function parseUrl()
    {
        $url = $_SERVER["REQUEST_URI"];
        $url = explode( '?',$url)[0];
        $this->url = $url;
    }
    public function get(string $get)
    {
        return $_GET[$get] ?? null;
    }
    public function post(string $get)
    {
        return $_POST[$get] ?? null;
    }
    public function getUrl()
    {
        return $this->url;
    }

}