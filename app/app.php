<?php
	use App\lib\Request\Request;
	use App\Http\RouteList;
	use App\lib\Router;
	use DI\ContainerBuilder;


	/*
	|--------------------------------------------------------------------------
	| Load Composer Autoloader
	|--------------------------------------------------------------------------
	*/
	require __DIR__ . '/../vendor/autoload.php';

	/*
	|--------------------------------------------------------------------------
	| Create and build the IoC Container with config
	|--------------------------------------------------------------------------
	|https://github.com/PHP-DI/PHP-DI
	|
	*/
	$containerBuilder = new ContainerBuilder;
	$containerBuilder->addDefinitions(__DIR__.'/config/php-di-config.php');
	$container = $containerBuilder->build();

	/*
	|--------------------------------------------------------------------------
	| Load Enviroment Configurations (.env)
	|--------------------------------------------------------------------------
	|
	|https://github.com/vlucas/phpdotenv
	|
	*/
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();

	/*
	|--------------------------------------------------------------------------
	| Init Request
	|--------------------------------------------------------------------------
	*/
	$request = new Request;

	/*
	|--------------------------------------------------------------------------
	| Load Routes list
	|--------------------------------------------------------------------------
	*/
	$routes = new RouteList;

	/*
	|--------------------------------------------------------------------------
	| Init Router and 'feed' it with the Route's list and Request
	|--------------------------------------------------------------------------
	*/
	$router = new Router($routes, $request);

	/*
	|--------------------------------------------------------------------------
	| Extract Controller and Method
	|--------------------------------------------------------------------------
	*/
	$controller = [
		$router->controller,
		$router->method,
	];

	/*
	|--------------------------------------------------------------------------
	| Call Controller and method
	|--------------------------------------------------------------------------
	*/
	$container->call($controller, [$router->params]);