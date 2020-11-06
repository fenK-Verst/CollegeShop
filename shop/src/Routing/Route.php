<?php


namespace App\Routing;

/**
 * Class Route
 *
 * @package App\Routing
 */
class Route
{
    private ?string             $controller;
    private ?string             $method;
    private array               $params;
    private string              $url;
    private array               $sharedParams = [];
    private int                 $statusCode   = 200;



    /**
     * Route constructor.
     *
     * @param string      $url
     * @param string|null $controller
     * @param string|null $method
     * @param array       $params
     */
    public function __construct(
        string $url,
        array $params = [],
        string $controller = null,
        string $method = null
    ) {
        $this->url = $url;
        $this->params = $params;
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return string|null
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string|null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $param
     *
     * @return mixed|null
     */
    public function get(string $param)
    {
        return $this->params[$param] ?? null;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getSharedParams(): array
    {
        return $this->sharedParams;
    }

    /**
     * @param array $sharedParams
     */
    public function setSharedParams(array $sharedParams): void
    {
        $this->sharedParams = $sharedParams;
    }

    public function addSharedData(string $key, $value)
    {
        $this->sharedParams['app'][$key] = $value;
    }
}