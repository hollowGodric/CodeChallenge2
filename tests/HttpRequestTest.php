<?php

use PHPUnit\Framework\TestCase;

class HttpRequestTest extends TestCase
{
    private static $serverVars;
    private static $postVars;
    private static $getVars;

    public static function setUpBeforeClass()/* The :void return type declaration that should be here would cause a BC issue */
    {
        self::$serverVars = $_SERVER;
        self::$postVars   = $_POST;
        self::$getVars    = $_GET;
        parent::setUpBeforeClass();
    }

    public function tearDown()
    {
        $_GET    = self::$getVars;
        $_POST   = self::$postVars;
        $_SERVER = self::$serverVars;
    }

    public function testGet()
    {
        $_GET['test']  = 'foobar';
        $_GET['test2'] = 'barbaz';
        $request       = new App\HttpRequest;
        $this->assertEquals('foobar', $request->get('test'));
        $this->assertEquals('barbaz', $request->get('test2'));
        $this->assertEquals('barbaz', $request->get('test3', 'barbaz'));
        $this->assertEquals('barbaz', $request->get('test3', 'barbaz'));
    }

    public function testPost()
    {
        $_POST['test']  = 'foobar';
        $_POST['test2'] = 'barbaz';
        $request        = new App\HttpRequest;
        $this->assertEquals('foobar', $request->get('test'));
        $this->assertEquals('barbaz', $request->get('test2'));
        $this->assertEquals('barbaz', $request->get('test3', 'barbaz'));
        $this->assertEquals('barbaz', $request->get('test3', 'barbaz'));
    }

    public function testGetHeaders()
    {
        $_SERVER['HTTP_X_CUSTOM'] = 'custom';
        $_SERVER['HTTP_USER_AGENT'] = 'Matrix';

        $request = new \App\HttpRequest();
        $this->assertEquals('custom', $request->getHeaders()['X_CUSTOM']);
    }
}
