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

		public function getAll():array
		{
			//$this->db->query('SELECT * FROM posts');
			$result = $this->db->table('posts')
						->select(['*'])
						->query();
			return $result;
		}

		public function show(int $id) 
		{
			$post = 'posts';
			//$this->db->query('SELECT * FROM posts WHERE id=:id');
			//$this->db->bind(':id', $id);

			//$result = $this->db->first();
			$result = $this->db->table('posts')
						->select(['*'])
						->where('id','=', $id)
						->query();

			return $result;
		}

		public function create(string $title) 
		{
        	$post = $this->db
        				->table('posts')
						->where('id','=', $id)
						->query();

			return $result;

        	$this->db->execute();
		}

		public function update(int $id, array $newValues) 
		{
			$newTitle = $newValues['title'];
			$post = $this->db
						->table('posts')
						->where('id','=', $id)
						->update(['title' => $newTitle])
						->query();
		}

		public function delete(int $id) 
		{
			$post = $this->db
						->table('posts')
						->where('id','=', $id)
						->delete()
						->query();
		}
	}
