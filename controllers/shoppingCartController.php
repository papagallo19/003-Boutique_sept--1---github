<?php

class ShoppingCartController extends CommonController
{
	

	public function defaultAction()
	{
		$this->showAction();
	}

	public function addProductAction()
	{
		(new ShoppingCartManager())->addOne($_GET['id']);
		
// var_dump($_SESSION);
// die();

		header('Location: '.CLIENT_ROOT.'shoppingCart/');
	}

	public function showAction()
	{
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;

//récupération des id des produits du panier
		$shoppingCartManager = new ShoppingCartManager();
		$ids = $shoppingCartManager->getIds();

//récupération des produits du panier
		$productsManager = new ProductsManager();
		$products = $productsManager->getByIds($ids);

//	Injection d'informations supplémentaires concernant les produits du panier
		foreach($products as $index => $product)
		{
			$quantity = $shoppingCartManager->getQuantityById($product['id']);
			$products[$index]['quantity'] = $quantity;
			$products[$index]['subTotal'] = $product['priceTTC'] * $quantity;
		}

		$data = compact('categories', 'shoppingCart', 'products');
		new View('shoppingCart/shoppingCart', $data);
	}
	
	public function removeProductAction()
	{
		(new ShoppingCartManager())->removeOne($_GET['id']);
		header('Location: '.CLIENT_ROOT.'shoppingCart/');
	}

	public function actualizeAction()
	{

		foreach($_POST['shoppingCart'] as $idProduct => $quantity)
		{
			if($quantity<1)
			{
				$quantity = (new ShoppingCartManager())->getQuantityById($idProduct);
			}
			$shoppingCart[$idProduct]= intval($quantity);
		}

		(new ShoppingCartManager())->actualize($shoppingCart);

		header('Location: '.CLIENT_ROOT.'shoppingCart/');
		exit();
		
	}

}
























