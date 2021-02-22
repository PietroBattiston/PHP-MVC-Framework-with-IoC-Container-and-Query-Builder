<?php declare(strict_types=1);

	namespace App\lib\Database;
	use \PDO;

	class Database implements DatabaseInterface
	{
		private $dbHost;
		private $dbUser;
		private $dbPass;
		private $dbName;

		private $statement;
		private $DBHandler;
		private $error;


		function __construct() 
		{
			$this->dbHost = $_ENV['DB_HOST'];
			$this->dbUser = $_ENV['DB_USER'];
			$this->dbPass = $_ENV['DB_PASS'];
			$this->dbName = $_ENV['DB_NAME'];


			$conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
			$options = [
				\PDO::ATTR_PERSISTENT=> TRUE,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			];

			try {
				$this->DBHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
			} catch (PDOExcepion $e) {
				$this->error = $e->getMessage();
				echo $this->error;
			}
		}

		public function query($sql)
		{
			$this->statement = $this->DBHandler->prepare($sql);
		}

		public function bind($param, $value, $type = NULL)
		{
			switch (is_null($type)) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				
				default:
					$type = PDO::PARAM_STR;
			}

			$this->statement->bindValue($param, $value, $type);
		}


		public function execute()
		{
			$this->statement->execute();
			return $this->rowCount();
		}

		public function get()
		{
			$this->execute();
			return $this->statement->fetchAll(PDO::FETCH_OBJ);
		}

		public function first()
		{
			$this->execute();
			return $this->statement->fetch(PDO::FETCH_OBJ);
		}

		public function rowCount()
		{
			return $this->statement->rowCount();
		}
	}
