<?php
	use App\lib\Router;
	use App\Http\RouteList;
	use DI\ContainerBuilder;


	// Load Composer Autoloader
	require __DIR__ . '/vendor/autoload.php';
	// Load Config File
	require_once '../app/config/config.php';
	

	
	// Create and Build Container 
	$containerBuilder = new ContainerBuilder;
	$container = $containerBuilder->build();


	//Load routes list
	$routes = new RouteList;
	//Init Router and 'feed' it with the routes
	$router = new Router($routes);

	$controller = [
		$router->controller,
		$router->method,
	];

	var_dump($controller);
	// Call Controller
	//$container->call($controller);

	// Call Controller
	//$container->call($controller, [32]);

	$container->call($controller, [$router->params]);

// use DI\ContainerBuilder;
// use App\lib\DB;
// $class = 'User';
// $containerBuilder = new ContainerBuilder();
// $containerBuilder->addDefinitions(__DIR__.'/config/php-di-config.php');

// $container = $containerBuilder->build();

// $container->get('DB');
