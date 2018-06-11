<?php

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @param $path
     * @param $pattern
     *
     * @param $method
     * @param $exactMatch
     * @dataProvider provideRouteRequestData
     */
    public function testRouteRequest($path, $pattern, $method, $exactMatch)
    {
        $flag        = false;
        $mockRequest = $this->createMock(\App\HttpRequest::class);
        $mockRouter  = $this->createMock(\App\RouteMatcherInterface::class);

        $mockRequest->method('getPath')->willReturn($path);
        $mockRequest->method('getMethod')->willReturn($method);
        if (!$exactMatch) {
            $mockRouter->method('match')->with($path, $pattern)->willReturn(['arg']);
        }

        $router = new \App\Router($mockRequest, $mockRouter);
        $router->addRoute($pattern, $method, function () use (&$flag) {
            $flag = true;
            return new \App\HttpResponse('');
        });
        $router->dispatch();

        $this->assertTrue($flag, 'Closure not executed');
    }

    public function provideRouteRequestData()
    {
        return [
            ['/challenges', '/challenges', 'GET', true],
            ['/score', '/score', 'POST', true],
            ['/challenges/2', '/challenges/{id}', 'GET', false],
            ['/challenges/2/3', '/challenges/{id}/{id2}', 'GET', false]
        ];
    }

    public function provideMismatchRouteRequestData()
    {
        return [
            ['/challenges', '/score', 'POST'],
            ['/challenges/2', '/challenged/{id}', 'GET']
        ];
    }

    /**
     * @dataProvider provideMismatchRouteRequestData
     * @param $path
     * @param $pattern
     * @param $method
     */
    public function testNotFoundRouteThrowException($path, $pattern, $method)
    {
        $flag        = false;
        $mockRequest = $this->createMock(\App\HttpRequest::class);
        $mockRouter  = $this->createMock(\App\RouteMatcherInterface::class);

        $mockRequest->method('getPath')->willReturn($path);
        $mockRequest->method('getMethod')->willReturn($method);
        $mockRouter->method('match')->with($path, $pattern)->willReturn([]);

        $router = new \App\Router($mockRequest, $mockRouter);
        $router->addRoute($pattern, $method, function () use (&$flag) {
            $flag = true;

            return new \App\HttpResponse('');
        });

        $response = $router->dispatch();
        $this->assertFalse($flag);
        $this->assertEquals(404, $response->getStatus());
    }

    public function provideTestMatches()
    {
        return [
            [
                '/challenges/2',
                '/challenges/{id}',
                [2]
            ],
            [
                '/challenges/2/anything',
                '/challenges/{id}/{otherthing}',
                [2, 'anything']
            ]
        ];
    }

    /**
     * @param $path
     * @param $pattern
     * @param $args
     * @dataProvider provideTestMatches
     */
    public function testRouteMatcher($path, $pattern, $args)
    {
        $matcher = new \App\RouteMatcher();

        $this->assertEquals($args, $matcher->match($path, $pattern));
    }
}
