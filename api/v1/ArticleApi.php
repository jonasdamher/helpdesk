<?php

declare(strict_types=1);

class ArticleApi extends Api
{

	public function __construct()
	{
		Auth::access();
		$this->loadModels(['article', 'generalArticle']);
	}

	public function new()
	{
		echo 'nuevo en la api';
	}

	public function read()
	{
	}

	public function update()
	{
	}

	public function delete()
	{
	}
}
