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
						->get();

			return $result;
		}

		public function create(array $values) 
		{
        	$post = $this->db
        				->table('posts')
						->create($values);
			return $post->affectedRows;
		}

		public function update(int $id, array $newValues) 
		{

			$post = $this->db
						->table('posts')
						->where('id','=', $id)
						->update(['title' => $newValues['title']]);
			return $post->affectedRows;
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
