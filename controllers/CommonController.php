<?php

class CommonController extends Controller{

	public $categories;

	public $shoppingCart;

	public function __construct()
	{

		$this->categories = (new CategoriesManager())->getAll();

		$shoppingCartManager = new ShoppingCartManager();
		$this->shoppingCart = 
			[
				'numberOfProducts' => $shoppingCartManager->getNumberOfProducts(),
				'totalAmount' =>$shoppingCartManager->getTotalAmount()
			];
	}

}