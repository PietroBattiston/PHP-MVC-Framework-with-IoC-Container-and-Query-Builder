<?php declare(strict_types=1);

namespace App\Http;


	class RouteList
    {
	

		public function routes()
        {
			$routeList = [
                'GET' => [
                    '/' => 'ExampleController@index',
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

        return $routeList;
			
		}
	}