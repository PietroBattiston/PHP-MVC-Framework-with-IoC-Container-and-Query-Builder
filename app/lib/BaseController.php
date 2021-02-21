<?php declare(strict_types=1);

	namespace App\lib;

	class BaseController {
		protected function loadModel($model) {
			//require_once '../Models/' . $model . '.php';
			$model = 'App\Models\\' . $model;
			return new $model;
		}

		protected function view(string $view, string $dataName, array $data = []) {
			//echo $this->twig->render('index.twig', [
			$view = $view . '.twig';
			echo $this->twig->render($view, [
            	$dataName => $data,
        	]);
		}
	}

	