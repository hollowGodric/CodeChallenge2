<?php

namespace App;


class Router
{
    /**
     * @var HttpRequest
     */
    private $request;
    private $routes    = [];
    private $arguments = [];
    private $routeMatcher;

    /**
     * Router constructor.
     * @param HttpRequest $request
     * @param             $routeMatcher
     * @internal param HttpRequest $param
     */
    public function __construct(HttpRequest $request, \App\RouteMatcherInterface $routeMatcher)
    {
        $this->request      = $request;
        $this->routeMatcher = $routeMatcher;
    }

    public function dispatch(): HttpResponse
    {
        try {
            return call_user_func_array($this->matchPattern(), $this->arguments);
        } catch (\Exception $exception) {
            return new HttpResponse($exception->getMessage(), 404);
        }
    }

    public function addRoute($pattern, $method, \Closure $closure)
    {
        $this->routes[$method][$pattern] = $closure;
    }

    private function matchPattern(): \Closure
    {
        $path   = $this->request->getPath();
        $method = $this->request->getMethod();

        foreach ((array)$this->routes[$method] as $pattern => $closure) {
            if ($path == $pattern) {
                return $closure;
            } else {
                if ($arguments = $this->routeMatcher->match($path, $pattern)) {
                    $this->arguments = $arguments;

                    return $closure;
                }
            }
        }

        throw new \Exception("Failed to match any known routes");
    }

}