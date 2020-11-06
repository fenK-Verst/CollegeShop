<?php

use App\Config;
use App\Entity\CustomRoute;
use App\Entity\EntityInterface;
use App\Entity\Flag;
use App\Entity\Folder;
use App\Entity\Image;
use App\Entity\Menu;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\ProductComment;
use App\Entity\ProductParam;
use App\Entity\ProductParamValue;
use App\Entity\SiteParams;
use App\Entity\Stonk;
use App\Entity\Template;
use App\Entity\User;
use App\Entity\Vendor;

define("PROJECT_DIR", __DIR__ . "/../../");

require_once(PROJECT_DIR . "/vendor/autoload.php");

$entities = [
    Product::class,
    Flag::class,
    Folder::class,
    Image::class,
    User::class,
    Vendor::class,
    ProductParamValue::class,
    ProductParam::class,
    ProductComment::class,
    Order::class,
    OrderItem::class,
    Menu::class,
    CustomRoute::class,
    Template::class,
    SiteParams::class,
    Stonk::class
];
$config = new Config();
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
    $reflection_class = new ReflectionClass($entity);
    $short_name =  $reflection_class->getShortName();
    $file = fopen(PROJECT_DIR.$dir."".$short_name."Proxy.php", "w") or die('Permission error');
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
     * @param \$primaryKeyValue
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

        if($method->isPublic()  && !$method->isStatic()/*&& $method->class == $entity*/){
            $method_name = $method->getName();
            $reflection_params = $method->getParameters();
            $params = [];
            $vars = [];
            foreach ( $reflection_params as $param){
                if ($param->getClass()) {
                    $type = "?\\" . $param->getType();
                } elseif ($param->getType() && $param->getType()->allowsNull()) {
                    $type = "?" . $param->getType();
                } else {

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