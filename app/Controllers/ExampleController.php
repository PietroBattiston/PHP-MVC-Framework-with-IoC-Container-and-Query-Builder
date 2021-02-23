<?php declare(strict_types=1);
	namespace App\Controllers;
	use App\lib\BaseController;
	use App\Models\ModelExample;
	use App\lib\Request\Request;
	use Twig\Environment;


	class ExampleController extends BaseController 
	{
	    public function __construct(ModelExample $model, Request $request, Environment $twig)
	    {
	        $this->model = $model;
	        $this->request = $request;
	        $this->twig = $twig;
	    }

	    public function index()
	    {
	    	$posts = ['First Post', 'Second Post', 'Thirth Post'];

	    	$this->view('index', 'posts', $posts);
	    }

}