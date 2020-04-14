<?php


namespace App\Di;


class Injector
{
    /**
     * @var Container
     */
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    public function createClass(string $class_name)
    {
        $reflection_class = new \ReflectionClass($class_name);
        $reflection_constructor = $reflection_class->getConstructor();
        $params = $this->getDependenciesArray($reflection_constructor);

        return $reflection_class->newInstanceArgs($params);

    }
    public function getDependenciesArray(\ReflectionMethod $reflection_constructor){
        $reflection_params = $reflection_constructor->getParameters();
        $params = [];
        foreach ($reflection_params as $reflection_param){
            $param_class = $reflection_param->getClass();
            if (!$param_class) {
                throw new \Exception("Invalid class in var ".$reflection_param->getName());
            }
            $class_name = $param_class->getName();
            $params[] = $this->container->get($class_name);
        }
        return $params;
    }
}