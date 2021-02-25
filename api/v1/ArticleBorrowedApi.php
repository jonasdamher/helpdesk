<?php

declare(strict_types=1);

class ArticleBorrowedApi extends Api
{

	public function __construct()
	{
		Auth::access();
		$this->loadModels(['ArticleBorrowed', 'Article']);
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
