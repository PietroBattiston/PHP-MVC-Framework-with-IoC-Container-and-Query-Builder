<?php declare(strict_types=1);

	namespace App\lib;

	class BaseController {
		protected function loadModel($model) {
			//require_once '../Models/' . $model . '.php';
			$model = 'App\Models\\' . $model;
			return new $model;
		}

		protected function view($view, $data = []) {
			if (file_exists('../app/Views/' . $view . '.view.php')) {
				require_once('../app/Views/' . $view . '.view.php');
			}else{
				die(`View $view does not exist`);
			}
		}
	}

	