<?php declare(strict_types=1);

namespace App\Http;


	class RouteList {
	

		public function routes() {
			 $routeList = [
            'GET' => [
                'url' => 'ExampleController@index',
                'show/{$param}' => 'ExampleController@show',
                'create/{$param}' => 'ExampleController@create',
                'update/{$id}' => 'ExampleController@update',
                'delete/{$id}' => 'ExampleController@delete',
            ],
            'PATCH' => [
                'update/{$id}' => 'ExampleController@update'
                
            ]
        ];

        return $routeList;
			
		}
	}