<?php
	use App\lib\Router;
	use App\Http\RouteList;
	use DI\ContainerBuilder;


	// Load Composer Autoloader
	require __DIR__ . '/vendor/autoload.php';
	// Load Config File
	

	
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
	| Load Routes list
	|--------------------------------------------------------------------------
	*/
	$routes = new RouteList;

	/*
	|--------------------------------------------------------------------------
	| Init Router and 'feed' it with the routes
	|--------------------------------------------------------------------------
	*/
	$router = new Router($routes);

	/*
	|--------------------------------------------------------------------------
	| Extract Controller and Method
	|--------------------------------------------------------------------------
	*/
	$controller = [
		$router->controller,
		$router->method,
	];

	var_dump($controller);
	
	/*
	|--------------------------------------------------------------------------
	| Call Controller and method
	|--------------------------------------------------------------------------
	*/
	$container->call($controller, [$router->params]);