<?php

class ShoppingCartManager 
{

	public function __construct()
	{
		//	Démarrage de la session si besoin
			if(session_status() !== PHP_SESSION_ACTIVE)
			{
				session_start();
			}
			//	Génération d'un nouvel identifiant de session (sécurité renforcée)
			session_regenerate_id();

			//	Initialisation du panier si besoin
			if(!isset($_SESSION['shoppingCart']['products']))
			{
				$_SESSION['shoppingCart']['products'] = [];
			}
	}

	public function addOne($id)
	{
		if(!isset($_SESSION['shoppingCart']['products'][$id]))
		{
			$_SESSION['shoppingCart']['products'][$id] = 1;
		}
		else 
		{
			$_SESSION['shoppingCart']['products'][$id]++;
		}
	}

	public function removeOne($id)
	{
		unset($_SESSION['shoppingCart']['products'][$id]);
	}

	public function getIds()
	{
		return array_keys($_SESSION['shoppingCart']['products']);
	}

	public function getQuantityById($id)
	{
		return $_SESSION['shoppingCart']['products'][$id];
	}

	public function getNumberOfproducts()
	{
		return array_sum($_SESSION['shoppingCart']['products']);
	}

	public function getTotalAmount()
	{
		$ids = $this->getIds();

		$productsManager = new ProductsManager();

		$products = $productsManager->getByIds($ids);
		$totalAmount=0;
		foreach($products as $product)
		{
			$quantity = $this->getQuantityById($product['id']);
			$totalAmount += $product['priceTTC']*$quantity;
		}
		return $totalAmount;
	}

	public function actualize($shoppingCart)
	{
		$_SESSION['shoppingCart']['products']= $shoppingCart;

	}

	public function getAll()
	{
		$ids = $this->getIds();
// var_dump($ids); 

		$productsManager = new ProductsManager();
		$products = $productsManager->getByIds($ids);
// var_dump($products);

		// il nous faut nous procurer la quantité de produits 
		foreach($products as $index => $product)
		{
			$quantity = $this->getQuantityById($product['id']);
			$products[$index]['quantity']=$quantity;
			
		}
		return $products;
// var_dump($products);
	}
	

}

















