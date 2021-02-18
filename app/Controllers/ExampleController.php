<?php declare(strict_types=1);
	namespace App\Controllers;
	use App\lib\BaseController;
	use App\Models\ModelExample;
	/**
	 * 
	 */
	class ExampleController extends BaseController  {
	    public function __construct(ModelExample $model) {
	        //$this->postModel = 'hello';
	       // $this->model = $this->loadModel('ModelExample');
	        $this->model = $model;
	    }

	    public function index() {
	    	$posts = $this->model->getAll();
	    	return $posts;
	    }

	    public function testParam($param) {
	       echo 'hello'. $param;
	    }

	    public function show($param) {
	       $result = $this->model->show(intval($param));
	       var_dump($result);

	    }

	    public function create($param) {
	       $this->model->create($param);
	    }

	    public function update($param) {
	    	if (!empty($_REQUEST)) {
	    		$this->model->update(intval($param), $_REQUEST);
	    		echo 'ok';
	    	}
	    }

	    public function delete($param) {
	       $this->model->delete(intval($param));
	    }

}