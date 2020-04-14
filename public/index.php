<?php

use App\Di\Container;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

define("PROJECT_DIR", __DIR__ . "/../");
require_once(PROJECT_DIR . "/vendor/autoload.php");

$a = new Container();
$loader = new FilesystemLoader(PROJECT_DIR . '/templates');
$twig = new Environment($loader, [
    'cache' => PROJECT_DIR . '/var/cache',
]);

try {
    echo $twig->render('base.html.twig', ['name' => 'Fabien']);
} catch (LoaderError $e) {

} catch (RuntimeError $e) {

} catch (SyntaxError $e) {

}

