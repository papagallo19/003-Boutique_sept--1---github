<?php

class OrdersController extends CommonController
{
	public function showBillingFormAction()
	{

		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;

		$formManager = new FormManager();
		$billingInformation = $formManager->getAll('billingInformation');
// var_dump($_SESSION);
//svar_dump($billingInformation);

		// suppression des erreurs en mémoire dans la session
		$formManager->saveErrors([], 'billingInformation');

		// Affichage des erreurs 
		// liste des messages d'erreur :
		$ErrorMessages =
		[
			'civilite' => 'Merci d\'indiquer votre civilite',
			'prénom' => 'Merci d\'indiquer votre prénom',
			'nom' => 'Merci d\'indiquer votre nom',
			'adresse' => 'Merci d\'indiquer votre adresse',
			'codepostal' => 'Merci d\'indiquer votre code postal',
			'commune' => 'Merci d\'indiquer votre ville',
			'pays' => 'Merci d\'indiquer votre pays',
			'telephone' => 'Merci d\'indiquer votre telephone'
		];

		// conservation des messages d'erreur :
		$billingInformation['errors'] = array_intersect_key($ErrorMessages, $billingInformation['errors']);



		$data = compact('categories', 'shoppingCart', 'billingInformation');
		new View ('orders/billingForm', $data);
	}

	public function saveBillingInformationAction()
	{
		// $shoppingCart = $this->shoppinCart;

		$billingInformation = array_map('trim', $_POST);


		if(!in_array($billingInformation['civilite'], ['M', 'Mme', 'Mlle']))
		{
			$errors['civilite']=true;
			unset($billingInformation['civilite']);
		}
		if(empty($billingInformation['prenom']))
		{
			$errors['prenom']=true;
			unset($billingInformation['prenom']);
		}
		if(empty($billingInformation['nom']))
		{
			$errors['nom']=true;
			unset($billingInformation['nom']);
		}
		if(empty($billingInformation['adresse']))
		{
			$errors['adresse']=true;
			unset($billingInformation['adresse']);
		}
		if(empty($billingInformation['codePostal']))
		{
			$errors['codePostal']=true;
			unset($billingInformation['codePostal']);
		}
		if(empty($billingInformation['commune']))
		{
			$errors['commune']=true;
			unset($billingInformation['commune']);
		}
		if(!in_array($billingInformation['pays'], ['France', 'Allemagne', 'Angleterre']))
		{
			$errors['pays']=true;
			unset($billingInformation['pays']);
		}
		if(empty($billingInformation['telephone']))
		{
			unset($billingInformation['telephone']);
		}
		elseif (!ctype_digit($billingInformation['telephone'])) {
			$errors['telephone']=true;
			unset($billingInformation['telephone']);
		}
		$formManager = new FormManager();

		if(count($billingInformation)>0)
		{
			$formManager->saveData($billingInformation, 'billingInformation');
		}


		if(isset($errors))
		{
			$formManager->saveErrors($errors, 'billingInformation');

			//	Redirection vers le formulaire
				header('Location:'.CLIENT_ROOT.'orders/showBillingForm/');
				exit();
		}
		else
		{
			header('Location: '.CLIENT_ROOT.'orders/saveOne/');
		}

	}

	public function saveOneAction()
	{
		 
		$formManager = new FormManager();
		// récupération des infos de facturation 
		$billingInformation = $formManager->getAll('billingInformation');
		//var_dump($billingInformation);
		$billingInformation = $deliveryInformation = $billingInformation['data'];

		$shoppingCartManager = new ShoppingCartManager();	
		$shoppingCart = $shoppingCartManager->getAll();
// var_dump($shoppingCart);
// var_dump($deliveryInformation);
// var_dump($_SESSION);die();
		$idCustomer = $_SESSION['customer']['id'];

		$ordersManager = new ordersManager();

		$order = $ordersManager->saveOne($billingInformation, $deliveryInformation, $shoppingCart, $idCustomer);	

		
		header('Location:'.CLIENT_ROOT.'orders/showOrder/');
		exit();
	}

	public function showOrderAction()
	{
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;
// var_dump($shoppingCart);
// var_dump($categories);

		//récupération des produits du panier
		$productsManager = new ProductsManager();
		$ids = array_keys($_SESSION['shoppingCart']['products']);
		$products = $productsManager->getByIds($ids);

//	Injection d'informations supplémentaires concernant les produits du panier
		$shoppingCartManager = new ShoppingCartManager();
		foreach($products as $index => $product)
		{
			$quantity = $shoppingCartManager->getQuantityById($product['id']);
			$products[$index]['quantity'] = $quantity;
			$products[$index]['subTotal'] = $product['priceTTC'] * $quantity;
		}
//var_dump($products);
		

		$data = compact('categories', 'shoppingCart', 'products');
		new View ('shoppingCart/showOrder', $data);

		

	}
}

























