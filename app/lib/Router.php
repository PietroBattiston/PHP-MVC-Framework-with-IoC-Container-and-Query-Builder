<?php declare(strict_types=1);

namespace App\lib;

use App\Http\RouteList;
use App\lib\Request\RequestInterface;


	class Router
	{
		private $currentUrl = [];
		private $routeList;
		private $requestMethod = '';
		public $controller;
		public $method;
		public $params = [];
		
		function __construct(RouteList $routeList, RequestInterface $request) {
			$this->request = $request;
			$this->controller = 'PagesController';
			$this->method = 'Page404';
			$this->routeList = $routeList->routes();
			$this->currentUrl = $this->getUrl();
			$search = $this->searchInRouteList($this->getRouteListKeys());
			if (!empty($search)) { 
				$this->extractControllerAndMethod($search);
			}
			// Add the full Namespace to Controller
			$this->controller = 'App\Controllers\\'. $this->controller;
		}

		/*
		|--------------------------------------------------------------------------
		| Get the current URI, trim, sanitize, and explode it
		|--------------------------------------------------------------------------
		*/
		public function getUrl():array
		{
			if (!empty($this->request->getURI()) && !empty($this->request->getMethod())) {
				$this->currentUrl = $this->request->getURI();
				$this->requestMethod = $this->getRequestMethod();
				$this->currentUrl = trim($this->currentUrl, '/');
				$this->currentUrl = filter_var($this->currentUrl, FILTER_SANITIZE_URL);
				$this->currentUrl = $this->explode('/',$this->currentUrl);
			}
			return $this->currentUrl;
		}


		/*
		|--------------------------------------------------------------------------
		| Get the HTTP Method
		|--------------------------------------------------------------------------
		*/
		private function getRequestMethod()
		{
			return $this->request->getMethod();
			
		}

		/*
		|--------------------------------------------------------------------------
		| Compare the Current URI with URIs set inside the Routes List
		|--------------------------------------------------------------------------
		*/
		public function searchInRouteList(array $routeListKeys):string
		{
			$controllerAndMethod = '';
			foreach ($routeListKeys as $key) {
				$explodedKey = $this->explode('/',$key);
				// Find differences between the Current URL and Routes
				$diff = array_diff($explodedKey, $this->currentUrl);
				if ($this->verifyMatch($diff, $explodedKey) === TRUE) {
					// Extract 'Controller@Method' using the matching array key
					$controllerAndMethod = $this->routeList[$this->requestMethod][$key];
					$this->params = end($this->currentUrl);	
				}elseif(count($diff) === 0) {
					$controllerAndMethod = $this->routeList[$this->requestMethod][$key];
				}
			}

			return $controllerAndMethod;
		}

		/*
		|--------------------------------------------------------------------------
		| Extract Controller and Method once found a match inside Routes List
		|--------------------------------------------------------------------------
		*/
		public function extractControllerAndMethod($controllerAndMethod):void
		{
			// Controller and Method are separated by '@'. Extract them and set the
			// controller and method
			$controllerAndMethod = $this->explode('@', $controllerAndMethod);
			$this->controller = $controllerAndMethod[0];
			$this->method = $controllerAndMethod[1];
		}

		public function explode(string $delimiter, string $str):array {
			return explode($delimiter, $str);
		}

		public function getRouteListKeys():array
		{
			$routeListKeys = [];
			// Check if the HTTP Method of the Request is set inside RouteList
			if (array_key_exists($this->requestMethod, $this->routeList)) {
				//Get all the routes's keys for that HTTP Method
				$routeListKeys = array_keys($this->routeList[$this->requestMethod]);
			}
			
			return $routeListKeys;
		}


		/*
		|--------------------------------------------------------------------------
		| Check if the route is a real match
		|--------------------------------------------------------------------------
		|
		| If there's only one different element between the current URI and the route
		| check if that element is a parameter and if the URI and route have the same
		| length
		*/
		private function verifyMatch(array $diff, array $explodedKey):bool
		{
			if (count($diff) === 1 && $this->isUrlParameter($diff) && count($explodedKey) === count($this->currentUrl)) {

				return TRUE;
			}

			return FALSE;		
		}	

		/*
		|--------------------------------------------------------------------------
		| In case of one not matching element in URI, check if that element can be a
		|  a parameter set inside the route wrapped by {}
		|--------------------------------------------------------------------------
		*/
		private function isUrlParameter(array $diff):bool
		{
			$diff = array_values($diff)[0];
			// Return true if the string start with "{"
			if (strpos($diff, "{") === 0) {
				return true;
			}
			return false;
		}



	} 