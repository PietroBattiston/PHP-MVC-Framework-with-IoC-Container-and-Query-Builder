<?php declare(strict_types=1);

	namespace App\lib\Request;
	use App\lib\Request\RequestInterface;
	use Laminas\Diactoros\ServerRequestFactory;
	
	class Request implements RequestInterface
	{
		public $request;
		
		function __construct() 
		{
			$this->request = ServerRequestFactory::fromGlobals(
			    $_SERVER,
			    $_GET,
			    $_POST,
			    $_COOKIE,
			    $_FILES
			);

			return $this->request;
		}

		public function getServerParams() 
		{
			return $this->request->getServerParams();
		}

		public function getURI()
		{
			return $this->getServerParams()['REQUEST_URI'];
		}

		public function getBody()
		{
			return $this->request->getParsedBody();
		}

		public function getMethod()
		{
			$requestMethod = $this->getServerParams()['REQUEST_METHOD'];
			if (!empty($this->getBody()) && !isset($this->getBody()['_method'])) {
				$requestMethod = $this->getBody()['_method'];
			}
			var_dump($requestMethod);
			return $requestMethod;
		}

		public function getCookies()
		{
			return $this->request->getCookieParams();
		}

		public function getUploadedFiles()
		{
			return $this->request->getUploadedFiles();
		}

	}

		