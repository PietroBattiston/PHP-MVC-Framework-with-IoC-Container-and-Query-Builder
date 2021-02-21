<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\lib\Router;
use App\Http\RouteList;



final class RouterTest extends TestCase
{
    public function setUp():void {

       // $this->loadConfig = require_once '../app/config/config.php';
        $_SERVER["REQUEST_METHOD"] = 'GET';
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->routeList = [
            'GET' => [
                'url' => 'ExampleController@index',
                'url1/url2' => 'ExampleController@index',
                'url/url1/{param}' => 'ExampleController@index'
            ]
        ];
        $this->stub = $this->createStub(RouteList::class);

        // Configure the stub.
        $this->stub->method('routes')
             ->willReturn($this->routeList);

        //$this->router = new Router($this->stub);
        $this->router = '';
    }

    public function test_Router_Class_exist(): void {
        $_SERVER["REQUEST_URI"] = 'url/url/url';
        $this->router = new Router($this->stub);
        $this->assertInstanceOf(Router::class, $this->router);

    }

    public function test_URL_can_be_catch():void {   
        $_SERVER["REQUEST_URI"] = 'url/url/url';  
        $explodedURL = explode("/", $_SERVER["REQUEST_URI"]);
        $this->router = new Router($this->stub);
        $catchedURL = $this->router->getUrl();

        $this->assertTrue(is_array($catchedURL));
        $this->assertEquals($explodedURL, $catchedURL);
    }

    public function test_URL_from_RouteList_can_be_extract():void {
        $this->router = new Router($this->stub);
        $keys = $this->router->getRouteListKeys();
        
        $this->assertEquals($keys, array_keys($this->routeList[$this->requestMethod]));

    }
    public function test_Current_URL_can_be_searched_inside_RouteList():void {
        $this->router = new Router($this->stub);
       $keys = $this->router->getRouteListKeys();
       $search = $this->router->searchInRouteList($keys);

       $this->assertEquals($keys, array_keys($this->routeList[$this->requestMethod]));

    }

    public function test_Controller_and_method_can_be_extract():void {

        $_SERVER["REQUEST_URI"] = 'url';
        $this->router = new Router($this->stub);
        $this->router->extractControllerAndMethod($this->routeList['GET']['url']);
        $controllerAndMethod = explode('@', $this->routeList[$this->requestMethod][$_SERVER["REQUEST_URI"]]);

        $this->assertEquals($this->router->controller, $controllerAndMethod[0]);
        $this->assertEquals($this->router->method, $controllerAndMethod[1]);
    }

    public function test_a_not_matching_route_must_call_404_method():void {

        $_SERVER["REQUEST_URI"] = 'not/found';

        $this->router = new Router($this->stub);
        
        $this->assertEquals($this->router->method, 'Page404');
    }

    public function test_a_param_can_be_recognized_and_extract():void {

        $_SERVER["REQUEST_URI"] = 'url/url1/myparam';
        $explodedURL = explode('/', $_SERVER["REQUEST_URI"]);

        $this->router = new Router($this->stub);
        $this->assertEquals($this->router->params, end($explodedURL));
    }
}
