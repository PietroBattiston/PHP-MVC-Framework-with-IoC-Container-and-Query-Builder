<?php declare(strict_types=1);
	namespace App\Controllers;

	use App\lib\BaseController;

	
	class PagesController extends BaseController
	{
		
		public function Page404()
		{
			echo "404";
		}
	}