<?php declare(strict_types=1);
	
	namespace App\lib\Database\Interface;
	
	interface DatabaseInterface 
	
		public function query();
		public function execute();
	}