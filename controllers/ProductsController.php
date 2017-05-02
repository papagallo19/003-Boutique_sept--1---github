<?php

class ProductsController extends CommonController
{
	const NUMBER_PER_PAGE = 2;

	public function showAllAction()
	{
// var_dump($_SESSION);
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;
// var_dump($shoppingCart);	
		$productsManager = new ProductsManager();
		$numberProducts = $productsManager->getCountAll();

		$pagination =
		[
			'requestedPage' => (array_key_exists('page',$_GET)? $_GET['page']:1),
			'lastPage'=> ceil($numberProducts/self::NUMBER_PER_PAGE)
		];
		if($pagination['requestedPage'] < 1 OR $pagination['requestedPage'] > $pagination['lastPage'])
{
	exit('page inexistante');
}

		$products = $productsManager->getAll($pagination['requestedPage']);
		$data = compact('categories', 'shoppingCart', 'numberProducts','pagination', 'products' );

		new View ('products/showAll', $data);
	}	

	public function showOneAction()
	{
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;
		$product  = (new ProductsManager())->getOne($_GET['id']);
		$data = compact('categories', 'shoppingCart', 'product');
		new View ('products/showOne', $data);
	}

	public function showByCategoryAction()
	{
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;
		$category = (new CategoriesManager())->getOne($_GET['id']);
		if($category===false)
{
	exit('page inexistante');
}
		$productsManager = new ProductsManager();

		$pagination =
		[
			'requestedPage' =>(array_key_exists('page', $_GET)? $_GET['page']:1),
			'lastPage' => ceil($productsManager->getCountByCategory($category['id'])/self::NUMBER_PER_PAGE)
		];
		if($pagination['requestedPage']<1 OR $pagination['requestedPage']>$pagination['lastPage'])
{
	exit('page inexistante');
}
		$products = $productsManager->getAllByCategory($category['id'], $pagination['requestedPage']);
		$data = compact('categories', 'shoppingCart', 'category','pagination', 'products');
		
		new View ('products/showAll', $data);
	}

	public function showBySearchAction()
	{
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;
		$search = trim($_GET['search']);
		if(empty($search))
{
	exit ('remplissez le champ "recherche" s\'il vous plait');
}
		$numberProducts = (new ProductsManager())->getCountBySearch($search);

		$pagination = 
		[
			'requestedPage' =>(array_key_exists('page', $_GET)? $_GET['page']: 1),
			'lastPage'=>ceil($numberProducts/self::NUMBER_PER_PAGE) 
		];
		if($pagination['requestedPage']<1 OR $pagination['requestedPage']>$pagination['lastPage'])
{
	exit('cette page est inexistante');
}
		$products = (new ProductsManager())->getBySearch($search, $pagination['requestedPage']);

		$data = compact('categories', 'shoppingCart', 'search', 'numberProducts','pagination', 'products');
		new View ('products/showAll', $data);


	}
}































