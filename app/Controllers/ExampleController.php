<?php declare(strict_types=1);
	namespace App\Controllers;
	use Twig\Environment;

	use App\lib\BaseController;
	use App\Models\ModelExample;
	

	class ExampleController extends BaseController 
	{
	    public function __construct(ModelExample $model, Environment $twig) {
	        $this->model = $model;
	        $this->twig = $twig;
	    }

	    public function index()
	    {
	    	$posts = $this->model->getAll();

	    	$this->view('index', 'posts', $posts);
	    }

	    public function testParam($param)
	    {
	       echo 'hello'. $param;
	    }

	    public function show($param)
	    {
	       $post = $this->model->show(intval($param));
	       $this->view('post', 'post', $post);

	    }

	    public function create($param)
	    {
	       $create = $this->model->create($_POST);
	       var_dump($create);
	    }

	    public function update($param)
	    {
	    	var_dump($_REQUEST);
	    	if (!empty($_REQUEST)) {
	    		$data = [
	    			'title' => $_REQUEST['title']
	    		];
	    		$update = $this->model->update(intval($param), $data);
	    	}
	    }

	    public function delete($param)
	    {
	       $this->model->delete(intval($param));
	    }

}