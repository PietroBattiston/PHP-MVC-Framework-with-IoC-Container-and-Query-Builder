<?php declare(strict_types=1);

namespace App\Http;


	class RouteList {
	

		public function routes() {
			 $routeList = [
            'GET' => [
                '/' => 'ExampleController@index',
                'show/{$param}' => 'ExampleController@show',
                'delete/{$id}' => 'ExampleController@delete',
            ],
            'POST' => [
                'create' => 'ExampleController@create',
                'update/{$id}' => 'ExampleController@update'  
                
            ],
            'PATCH' => [
                'update/{$id}' => 'ExampleController@update'  
            ]
        ];

        return $routeList;
			
		}
	}