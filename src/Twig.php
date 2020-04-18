<?php


namespace App;
use \Twig\Environment;
use \Twig\Loader\FilesystemLoader;
use \Twig\TwigFunction;

class Twig
{
    private Config $config;
    private Environment $twig;
    public function __construct(Config $config)
    {
        $twig_config = $config->getTwigConfig();
        $loader = new FilesystemLoader(PROJECT_DIR.$twig_config["templates"]);
        $this->twig = new Environment($loader, [
            'cache' => PROJECT_DIR.$twig_config["cache"],
            'auto_reload' => $twig_config["auto_reload"]
        ]);
        $function = new TwigFunction('assets', function ($path) {
            return "/".$path;
        });
        $this->twig->addFunction($function);


    }
    public function render(string $template_name, array $params = [])
    {
        return $this->twig->render($template_name, $params);
    }
}