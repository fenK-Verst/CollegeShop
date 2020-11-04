<?php


namespace App;

use \Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use \Twig\Loader\FilesystemLoader;
use \Twig\TwigFunction;

class Twig
{
    private Environment $twig;

    /**
     * Twig constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $twig_config = $config->getTwigConfig();

        $loader = new FilesystemLoader(PROJECT_DIR . $twig_config["templates_dir"]);
        $this->twig = new Environment($loader, [
            'debug' => (bool)$twig_config["debug"],
            'cache' => PROJECT_DIR . $twig_config["cache"],
            'auto_reload' => $twig_config["auto_reload"]
        ]);
        $function = new TwigFunction('assets', function ($path) {
            return "/" . $path;
        });
        $this->twig->addFunction($function);
        $function = new TwigFunction('json_decode', function ($string) {
            return json_decode($string, true);
        });
        $this->twig->addFunction($function);
        $this->twig->addExtension(new DebugExtension());

    }

    /**
     * @param string $template_name
     * @param array  $params
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template_name, array $params = []): string
    {
        return $this->twig->render($template_name, $params);
    }
}