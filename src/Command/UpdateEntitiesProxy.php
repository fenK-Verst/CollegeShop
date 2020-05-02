<?php

use App\Entity\EntityInterface;

define("PROJECT_DIR", __DIR__ . "/../../");

require_once(PROJECT_DIR . "/vendor/autoload.php");

$entities = [
    \App\Entity\Product::class,
    \App\Entity\Flag::class,
    \App\Entity\Folder::class,
    \App\Entity\Image::class,
    \App\Entity\User::class,
    \App\Entity\Vendor::class,
    \App\Entity\ProductParamValue::class,
    \App\Entity\ProductParam::class,

];
$config = new \App\Config();
$proxy_config = $config->get("proxy") ?? null;
if (!$proxy_config) exit("Can't find proxy config");
$namespace = $proxy_config["namespace"];
if (!$namespace) exit("Can't find proxy namespace");
$dir = $proxy_config["dir"];
if (!$dir || !is_dir(PROJECT_DIR.$dir)) exit("Can't find proxy dir");
$files = glob(PROJECT_DIR.$dir.'/*');

foreach($files as $file) {
    if(is_file($file))
        unlink($file);
}
foreach ($entities as $entity){
    $reflection_class = new \ReflectionClass($entity);
    $short_name =  $reflection_class->getShortName();
    $file = fopen(PROJECT_DIR.$dir."".$short_name."Proxy.php", "w") or die('Permission error');;
    /**
     * @var EntityInterface $temp_entity
     */
    $temp_entity = new $entity();
    $p = $short_name."Proxy";
    $repository  = "\\".$temp_entity->getRepositoryClass();
    $content =
        "<?php


namespace $namespace;

class $p extends \\$entity
{
    private bool \$__inited = false;
    private $repository \$repository;
    private \$primaryKeyValue;
    private \\$entity \$parent;

    /**
     * $p constructor.
     *
     * @param $repository \$repository
     * @param \$primaryKey
     */
    public function __construct($repository \$repository, \$primaryKeyValue)
    {
        \$this->repository = \$repository;
        \$this->primaryKeyValue = \$primaryKeyValue;
    }

    private function init()
    {
        if (!\$this->__inited) {
            \$original = \$this->repository->find(\$this->primaryKeyValue);
            \$this->parent = \$original;
            \$this->__inited = true;
        }
    }
//    public function getEntityParams():array
//    {
//        \$this->init();
//        return \$this->parent->getEntityParams();
//    }
    
";
    $methods = $reflection_class->getMethods();
    foreach ($methods as $method){
        /**
         * @var ReflectionMethod $method
         */

        if($method->isPublic() /*&& $method->class == $entity*/){
            $method_name = $method->getName();
            $reflection_params = $method->getParameters();
            $params = [];
            $vars = [];
            foreach ( $reflection_params as $param){
                if ($param->getClass()){
                    $type="?\\".$param->getType();
                }else{
                    $type = $param->getType();
                }
                $params[] =  $type. " $". $param->getName();
                $vars[] = "$". $param->getName();

            }
            $params = implode(", ", $params);
            $vars = implode(", ", $vars);
            $return =$method->hasReturnType();
            $return_type = $method->getReturnType();
            $is_class  = class_exists($method->getReturnType());
              $content.=
              "    public function $method_name($params)";
              if ($return){
                  if ($is_class){
                      $content.=" : ?\\$return_type";
                  }else{
                      $content.=" : $return_type";
                  }
              }
              $content.="\n";
              $r = '';
              if ($return && $return_type != "void"){
                  $r = "return ";
              }
              $content.=
"    {
        \$this->init();
        $r\$this->parent->$method_name($vars);           
    }\n\n";
        }

    }
    $content.="}";
    fwrite($file, $content);

}