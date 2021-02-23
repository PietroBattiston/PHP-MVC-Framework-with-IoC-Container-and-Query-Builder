<?php declare(strict_types=1);

	namespace App\lib;

	class BaseController {
		protected function loadModel($model)
		{
			$model = 'App\Models\\' . $model;
			return new $model;
		}

		protected function view(string $view, string $dataName, array $data = []) {
			$view = $view . '.twig';
			echo $this->twig->render($view, [
            	$dataName => $data,
        	]);
		}
	}

	