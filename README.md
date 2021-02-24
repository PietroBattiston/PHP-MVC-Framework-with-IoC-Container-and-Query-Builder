# Simple PHP MVC Framework with DI Container and Query Builder
## Introduction
This framework is suitable for small projects. It has few (but nice) features. If you think you need more features you should probably choose an advanced framework.

### Features
- Query Builder
- Routing
- Views
- Dependency Injection Container


## Installation
Download or Clone the project
```sh
git clone https://github.com/PietroBattiston/PHP-MVC-Framework-with-IoC-Container-and-Query-Builder.git
```

And install the dependencies with composer
```sh
composer install
``` 

## Configuration
You will find an .env.example inside the app folder. Create a copy and rename it as .env

Set your environment configuration.


## Routing
You can define your routes inside RouteList.php
```php

//app/Http/Routelist.php

	$routeList = [
                'GET' => [
                    '/' => 'ExampleController@index',
		    '/show/{$id}' => 'ExampleController@show'
                ],
                'POST' => [
                    'create' => 'ExampleController@create',
                ],
                'PATCH' => [
                    'update/{$id}' => 'ExampleController@update'  
                ],
                'DELETE' => [
                    'delete/{$id}' => 'ExampleController@delete',
                ]
        ];
			

``` 
> Note: In case of not matching results, the Page404 method inside PagesController will be called. Consequently you must not delete those method/class but customize it as you like.

> Note: Add an hidden field inside your HTML form for methods as PATCH/PUT and DELETE with the relative method as value.
```HTML
<input name="_method" type="hidden" value="PATCH">
```

## Controllers
You will find an ExampleController and a PageController as examples.
```php

// app/Controllers/ExampleController.php

<?php declare(strict_types=1);

	namespace App\Controllers;
	use App\lib\BaseController;
	use App\Models\ModelExample;
	use Twig\Environment;
	
	class ExampleController extends BaseController 
	{
	    public function __construct(ModelExample $model, Environment $twig)
	    {
	        $this->model = $model;
	        $this->twig = $twig;
	    }
	    public function index()
	    {
	    	$posts = ['First Post', 'Second Post', 'Thirth Post'];

	    	$this->view('index', 'posts', $posts);
	    }
	}
```
> Note: Remember to extends the BaseController in your custom Controllers!

```php

// app/Controllers/PageController.php
<?php declare(strict_types=1);

	namespace App\Controllers;
	use App\lib\BaseController;
	
	class PagesController extends BaseController
	{
		public function Page404()
		{
			echo "404";
		}
	}
```
> Note: Don't delete PagesController and Page404 method as already mentioned in Routing Doc.

### Controller - Load View
```php
$this->view('YourView', 'somedata', $somedata);
```
> Note: please refer to Views Doc section.

## Models
You will find a ModelExample as example.
```php

// app/Models/ModelExample.php
<?php declare(strict_types=1);
	namespace App\Models;
	use App\lib\Database\DB;

	class ModelExample 
	{
		private $db;
		public function __construct(DB $db) 
		{
			$this->db = $db;
		}
	}
```
> Note: Class DB is the Query Builder. Please refer to the next section.

## Query Builder
The framework uses a Query Builder for simple queries. Please check some examples:
```php
$results = $this->db
		->table('posts')
		->select(['*'])
		->get();


$result = $this->db
		->table('posts')
		->select(['*'])
		->where('id','=', $id)
		->get();

$create = $this->db
        	->table('posts')
		->create($values);

$update = $this->db
		->table('posts')
		->where('id','=', $id)
		->update(['title' => $newValues['title']]);

$delete = $this->db
		->table('posts')
		->where('id','=', $id)
		->delete();

```
> Note: The QueryBuilder will call the Database class once obtained the final query. All the values are binded. Please refer to [PDO Bind Value](https://www.php.net/manual/en/pdostatement.bindvalue.php)

> WARNING: For security reasons you must always validate and sanitize data before sending it to the Builder.

## Requests
The framework is [PSR-7](https://www.php-fig.org/psr/psr-7/) compliant. Please check the following examples:
```php

	class Controller extends BaseController 
	{
		function __construct(Request $request)
		{
			$this->request = $request;
		}

		public function yourMethod()
		{
			$data = $this->request->getBody();
		}
	}
	
```
Request Class has other few method such as:
```php
		public function getBody()
		{
			return $this->request->getParsedBody();
		}

		public function getCookies()
		{
			return $this->request->getCookieParams();
		}

		public function getUploadedFiles()
		{
			return $this->request->getUploadedFiles();
		}
```
For other needs you can refer to [Laminas-Diactoros](https://docs.laminas.dev/laminas-diactoros/) which is used by this framework.


## Views
Views are located in 'app\Views'.

The framework uses [Twig](https://twig.symfony.com/) as Template Engine. Please refer to its own Documentation.

### PUT/PATCH/DELETE Methods
HTML forms don't support PUT, PATCH and DELETE method as you maybe already know. The framework can recognize an hidden field inside your form in order to recognize the right HTTP Method to use. Add inside your form an hidden field like this:

```HTML
	<input name="_method" type="hidden" value="PATCH">
```


## IoC
The framework uses [PHP-DI](https://php-di.org/) as Dependency Injection Container. Please refer to its own Documentation.
You can find the configuration file in "app\config\php-di-config.php".


## Security
This framework's version does not offer protection against [CSRF](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html).

The framework uses PDO for querying the database. The Query Builder uses the [PDO Prepare Statement](https://www.php.net/manual/en/pdo.prepare.php) and it [binds values](https://www.php.net/manual/en/pdostatement.bindvalue.php) in order to prevent [SQL Injections](https://owasp.org/www-community/attacks/SQL_Injection). 

### Report Bugs and Security Issue
Please let me know if you find any Bug or Security issue


## Contribute
Feel free to contribute to the project following the latest PHP Coding Style and Best practices :)
