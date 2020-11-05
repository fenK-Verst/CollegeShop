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
        $params = [];
        $reflection_class = new \ReflectionClass($class_name);
        $reflection_constructor = $reflection_class->getConstructor();
        if ($reflection_constructor)
            $params = $this->getDependenciesArray($reflection_constructor);

        return $reflection_class->newInstanceArgs($params);

    }

    public function getDependenciesArray(\ReflectionMethod $reflection_constructor)
    {
        $reflection_params = $reflection_constructor->getParameters();
        $params = [];
        foreach ($reflection_params as $reflection_param) {
            $param_class = $reflection_param->getClass();
            if ($param_class) {
                $class_name = $param_class->getName();
                $params[] = $this->container->get($class_name);
            }
        }
        return $params;
    }

    public function callMethod(Object $object, string $method)
    {
        $reflection_class = new \ReflectionClass($object);
        $reflection_method = @$reflection_class->getMethod($method);
        if (!$reflection_method) {
            throw new \Exception("Method $method does not exists");
        }
        $params = $this->getDependenciesArray($reflection_method);
        return call_user_func_array([$object, $method], $params);
    }
}