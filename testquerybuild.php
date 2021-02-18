<?php declare(strict_types=1);

	/**
	 * 
	 */
	class QueryBuilder
	{
		
		
		public static $table = '';
		public static $query = '';
		public static $statement = '';
		public static $bindedValues = [];


		static public function table(string $tableName) {
			
			self::$table = $tableName;

			//emptying values in case have been already used
			self::$query = '';
			self::$bindedValues = [];

			return new self;
		}

		static public function select(array $selectedColumn) {
			$selectedColumn = implode(',',$selectedColumn);
			self::$query = 'SELECT ' . $selectedColumn . ' FROM '. self::$table;
			return new self;
		}

		static public function update(array $updateColumns) {
			$query = 'UPDATE ' . self::$table . ' SET ';
			$loopIndex = 0;
			foreach ($updateColumns as $key => $value) {
					$loopIndex++;
					$columnName = $key;
					$bindValue = ':' . $columnName;
					self::$bindedValues[$bindValue] = $value;
					// If the numbers of elements inside the $updateColumns array is still greater than $loopIndex, a comma will separate the columns. Otherwise it will be set as empty. (title=:title,name=:name,etc.)
					$separator = count($updateColumns) > $loopIndex ? ',' : '';
					$query .= $columnName . '=' . $bindValue . $separator;
			}

			self::$query = $query . self::$query;
			var_dump(self::$bindedValues);
			return self::$query;
		}

		static public function get() {
			return self::$query;
		}

		static public function delete() {
			self::$query = 'DELETE FROM ' . self::$table . self::$query;

			return self::$query;
		}

		static public function where(string $column, string $param, $value) {
			$bindValue = ':' . $column;
			self::$bindedValues[$bindValue] = $value;
			if (count(self::$bindedValues) < 2) {
				// TO REFACTOR
				self::$query .= ' WHERE ' . $column . $param . $bindValue;
			}else{
				self::$query .= ' AND ' . $column . $param . $bindValue;
			}

			return new self;
		}

		static public function QueryDB() {
			$db = new Database;
			$db->query(self::$query);
			foreach ($bindedValues as $key => $value) {
				$db->bind($key, $value);
			}
			$result = $db->first();

			return $result;
		}
	}



	//INSERT INTO `posts` (`id`, `title`) VALUES ('1111', 'zzz');

	//SELECT * FROM mvc.posts;

	//DELETE FROM posts WHERE id>1;
	//DELETE FROM posts WHERE id=:id'
	//SELECT title, id FROM mvc.posts WHERE id < 82;
	//UPDATE posts SET title=:title WHERE id=:id

		//select table and get ALL
		//$db = QueryBuilder::table('mytable')->get();
		//var_dump($db);

		// DELETE ALL
		//$db = QueryBuilder::table('mytable')->delete();
		//var_dump($db);

		//WHERE
		//$db = QueryBuilder::table('mytable')->where('id','>','1;')->where('id','>','1;');
		//$db = QueryBuilder::table('mytable')->where('id','>','1')->where('dioporco','>','1')->get();

		// $db = QueryBuilder::table('posts')
		// 		->select(['*'])
		// 		->where('id','>','1')
		// 		->where('title','=','title')
		// 		->get();

		//var_dump($db);

		// $db = QueryBuilder::table('posts')
		// 		->where('id','>','1')
		// 		->where('title','=','title')
		// 		->delete();

		//var_dump($db);
		//$db = new QueryBuilder;
		//$db->table('mytable')->where('id','>','1;')->where('id','>','1;');
		//SELECT COLUMNS



		//UPDATE posts SET title=:title WHERE id=:id
		$db = QueryBuilder::table('posts')
				->where('id','>','1')
				->where('title','=','new-Title')

				->update(['title' => 'newTitle', 'id' => '32']);
		var_dump($db);




/**
 * 
 */
class Test
{
	 public function update(array $updateColumns) {
	 	

			$bindedValues = [];
			$table = 'myTable';
			$query = 'UPDATE ' . $table . ' SET ';
			$loopIndex = 0;
			foreach ($updateColumns as $key => $value) {
					$loopIndex++;
					$columnName = $key;
					$bindValue = ':' . $columnName;
					$bindedValues[$key] = $value;
					// If the numbers of elements inside the $updateColumns array is still greater than $loopIndex, a comma will separate the columns. Otherwise it will be set as empty. (title=:title,name=:name,etc.)
					$separator = count($updateColumns) > $loopIndex ? ',' : '';
					$query .= $columnName . '=' . $bindValue . $separator;
			}

			var_dump($query);
			
		}
}



//$test = new Test;
//$test->update(['title' => 'newTitle', 'id' => '32', 'text' => '32', 'lol' => '32']);