<?php declare(strict_types=1);
	
	namespace App\lib\Database;

	interface DatabaseInterface
	{
		public function query($sql);
		public function execute();
	}