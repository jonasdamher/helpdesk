<?php

declare(strict_types=1);

class ArticlePointOfSaleApi extends Api
{

	public function __construct()
	{
		Auth::access();
		$this->loadModels(['ArticlePointOfSale']);
	}

	public function new()
	{

		 
	}

	public function read($id = null)
	{
  
	}

	public function update()
	{
  
	}

	public function delete()
	{
 
	}
}
