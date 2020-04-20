<?php


namespace App;


class Config
{
    private array $config = [];
    private static string $dir = PROJECT_DIR . "config";

    public function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(PROJECT_DIR, ".env.local");
        $dotenv->load();
        $this->parseDir($this::$dir);
    }

    public function getConfig()
    {
        return $this->config;
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

    public function getControllers()
    {
        return $this->config["controllers"] ?? [];

    }

    public function getTwigConfig()
    {
        return $this->config["twig"] ?? [];
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