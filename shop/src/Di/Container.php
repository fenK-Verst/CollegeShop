<?php


namespace App\Di;


use App\Di\Exceptions\ClassNotExistsException;

class Container
{
    private array $interfaceMapping;
    private array $factories = [];
    private array $singletons = [];
    private Injector $injector;

    public function __construct(array $interface_mapping = [])
    {
        $this->interfaceMapping = $interface_mapping;
        $this->injector = new Injector($this);
    }

    /**
     * @param string $class_name
     * @return mixed|object
     * @throws ClassNotExistsException
     */
    public function get(string $class_name)
    {
        if (interface_exists($class_name)) {
            $class_name = $this->interfaceMapping[$class_name] ?? $class_name;
        }
        if (!class_exists($class_name)) {
            throw new ClassNotExistsException("Class $class_name does not exist");
        }
        return $this->getClass($class_name);
    }

    private function isSingleton(string $class_name)
    {
        return isset($this->singletons[$class_name]);
    }

    private function getSingleton(string $class_name)
    {
        $instance = $this->singletons[$class_name];
        if (false === $instance) {
            $instance = $this->createSingleton($class_name);
        }
        return $instance;
    }

    public function singleton(string $class_name, callable $callback = null)
    {
        if (is_callable($callback)) {
            $this->factories[$class_name] = $callback;
        }
        $this->singletons[$class_name] = false;
    }

    private function getClass(string $class_name)
    {
        if ($this->isSingleton($class_name)) {
            return $this->getSingleton($class_name);
        }
        return $this->getInstance($class_name);
    }

    private function createSingleton(string $class_name)
    {
        $is_factory_exists = $this->isFactoryExists($class_name);
        if ($is_factory_exists) {
            $factory = $this->getFactory($class_name);
            $instance = $factory();
        } else {
            $instance = $this->getInstance($class_name);

        }
        $this->singletons[$class_name] = $instance;

        return $instance;
    }

    private function getInstance($class_name)
    {
        return $this->injector->createClass($class_name);
    }

    private function isFactoryExists(string $class_name): bool
    {
        return isset($this->factories[$class_name]) && is_callable($this->factories[$class_name]);
    }

    private function getFactory(string $class_name): callable
    {
        return $this->factories[$class_name];
    }

    public function getInjector()
    {
        return $this->injector;
    }
}