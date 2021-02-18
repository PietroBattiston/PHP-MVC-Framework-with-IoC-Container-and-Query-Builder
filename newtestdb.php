<?php declare(strict_types=1);

	/**
	 * 
	 */
	class QueryBuilder
	{
		
		
		public $table = '';
		public $query = '';
		public $statement = '';
		public $bindedValues = [];


		public function table(string $tableName) {
			
			$this->table = $tableName;

			//emptying values in case have been already used
			$this->query = '';
			$this->bindedValues = [];

			return $this;
		}

		public function select(array $selectedColumn) {
			$selectedColumn = implode(',',$selectedColumn);
			$this->query = 'SELECT ' . $selectedColumn . ' FROM '. $this->table;
			return $this;
		}

		public function update(array $updateColumns) {
			$query = 'UPDATE ' . $this->table . ' SET ';
			$loopIndex = 0;
			foreach ($updateColumns as $key => $value) {
					$loopIndex++;
					$columnName = $key;
					$bindValue = ':' . $columnName;
					$this->bindedValues[$bindValue] = $value;
					// If the numbers of elements inside the $updateColumns array is still greater than $loopIndex, a comma will separate the columns. Otherwise it will be set as empty. (title=:title,name=:name,etc.)
					$separator = count($updateColumns) > $loopIndex ? ',' : '';
					$query .= $columnName . '=' . $bindValue . $separator;
			}

			$this->query = $query . $this->query;
			return $this;
		}

		public function get() {
			echo $this->query;
		}

		public function delete() {
			$this->query = 'DELETE FROM ' . $this->table . $this->query;

			return self::$query;
		}

		public function where(string $column, string $param, $value) {
			$bindValue = ':' . $column;
			$this->bindedValues[$bindValue] = $value;
			if (count($this->bindedValues) < 2) {
				// TO REFACTOR
				$this->query .= ' WHERE ' . $column . $param . $bindValue;
			}else{
				$this->query .= ' AND ' . $column . $param . $bindValue;
			}

			return $this;
		}

		public function QueryDB() {
			$db = new Database;
			$db->query(self::$query);
			foreach ($bindedValues as $key => $value) {
				$db->bind($key, $value);
			}
			$result = $db->first();

			return $result;
		}
	}


$db = new QueryBuilder;
$db->table('posts')->where('title','=','title')->select(['title'])->get();
