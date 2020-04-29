<?php


namespace App;


class Config
{
    private array $config = [];
    private static string $dir = PROJECT_DIR . "config";
    private static string $env_file = '.env.local';

    public function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(PROJECT_DIR, $this::$env_file);
        $dotenv->load();
        $this->parseDir($this::$dir);
    }

    public function getControllers()
    {
        return $this->config["config"]["controllers"] ?? [];

    }

    public function getTwigConfig()
    {
        return $this->config["config"]["twig"] ?? [];
    }

    public function getMiddlewares()
    {
        return $this->config["config"]["middlewares"] ?? [];
    }

    public function getConfig()
    {
        return $this->config;
    }
    public function get(string $needed)
    {
        return $this->config[$needed] ?? null;
    }
    private function parseDir(string $dir)
    {
        $files = glob($dir . "/*");
        foreach ($files as $file) {
            $info = pathinfo($file);

            if (is_dir($file)) {
                $this->parseDir($file);
            } else {
                $content = $this->parseFile($file);
                $path = explode("/", str_replace($this::$dir . "/", "", $file));
                $path[count($path) - 1] = $info["filename"];
                $path[] = $content;
                $path = array_reverse($path);
                $arr = [];
                $arr[$path[1]] = $path[0];
                for ($i = 2; $i < count($path); $i++) {
                    $a[$path[$i]] = $arr;
                    $arr = $a;
                }
                $this->config = array_replace_recursive($this->config, $arr);
            }
        }
    }


    private function parseFile(string $file)
    {
        if (is_dir($file)) return false;

        $info = pathinfo($file);
        switch ($info["extension"]) {
            case "yaml":
                return yaml_parse_file($file);
            case "json":
                $file = file_get_contents($file);
                return json_decode($file, true);
        }
    }

}