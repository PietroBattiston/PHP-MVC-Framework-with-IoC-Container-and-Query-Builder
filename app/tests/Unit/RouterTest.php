<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\lib\Router;
use App\Http\RouteList;
use App\lib\Request\Request;



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

        // Create Routes Stub
        $this->routesStub = $this->createStub(RouteList::class);

        // Configure Routes stub.
        $this->routesStub
            ->method('routes')
            ->willReturn($this->routeList);


        $this->requestStub = $this->createStub(Request::class);
        $this->requestStub
                ->method('getMethod')
                ->willReturn('GET');
        $this->router = '';
    }

    public function test_Router_Class_exist(): void {
        $this->requestStub
                ->method('getURI')
                ->willReturn('url/url/url');
        $this->router = new Router($this->routesStub, $this->requestStub);
        $this->assertInstanceOf(Router::class, $this->router);

    }

    public function test_URL_can_be_catch():void {   
       $this->requestStub
                ->method('getURI')
                ->willReturn('url/url/url');

        $explodedURL = explode("/", $this->requestStub->getURI());
        $this->router = new Router($this->routesStub, $this->requestStub);
        $catchedURL = $this->router->getUrl();

        $this->assertTrue(is_array($catchedURL));
        $this->assertEquals($explodedURL, $catchedURL);
    }

    public function test_URL_from_RouteList_can_be_extract():void {
        $this->requestStub
                ->method('getURI')
                ->willReturn('url/url/url');
        $this->router = new Router($this->routesStub, $this->requestStub);
        $keys = $this->router->getRouteListKeys();
        
        $this->assertEquals($keys, array_keys($this->routeList[$this->requestMethod]));

    }
    public function test_Current_URL_can_be_searched_inside_RouteList():void {
      $this->requestStub
                ->method('getURI')
                ->willReturn('url/url/url');
        $this->router = new Router($this->routesStub, $this->requestStub);
       $keys = $this->router->getRouteListKeys();
       $search = $this->router->searchInRouteList($keys);

       $this->assertEquals($keys, array_keys($this->routeList[$this->requestMethod]));

    }

    public function test_Controller_and_method_can_be_extract():void {

        $this->requestStub
                ->method('getURI')
                ->willReturn('url');
        $this->router = new Router($this->routesStub, $this->requestStub);
        $this->router->extractControllerAndMethod($this->routeList['GET']['url']);
        $controllerAndMethod = explode('@', $this->routeList[$this->requestMethod][$this->requestStub->getURI()]);

        $this->assertEquals($this->router->controller, $controllerAndMethod[0]);
        $this->assertEquals($this->router->method, $controllerAndMethod[1]);
    }

    public function test_a_not_matching_route_must_call_404_method():void {

        $this->requestStub
                ->method('getURI')
                ->willReturn('not/found');
        $this->router = new Router($this->routesStub, $this->requestStub);
        
        $this->assertEquals($this->router->method, 'Page404');
    }

    public function test_a_param_can_be_recognized_and_extract():void {

        $this->requestStub
                ->method('getURI')
                ->willReturn('url/url1/myparam');
        $explodedURL = explode('/', $this->requestStub->getURI());
        $this->router = new Router($this->routesStub, $this->requestStub);
        
        $this->assertEquals($this->router->params, end($explodedURL));
    }
}
