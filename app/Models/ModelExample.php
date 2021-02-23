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
