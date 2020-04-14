<?php


namespace App\Controller;


use App\Http\Response;

abstract class AbstractController
{

    public function render(string $template_name, $params = [])
    {
            return new Response("Folder");
    }
}