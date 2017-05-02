<?php


class CustomersController extends CommonController
{
	public function signUpAction()
	{
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;

		$data = compact('categories', 'shoppingCart');
		
		new View ('customers/signUp', $data);

	}
	public function signInAction()
	{
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;

		$data = compact('categories', 'shoppingCart');
		
		new View ('customers/signIn', $data);
	}

	public function createAccountAction()
	{

		if($_SERVER['REQUEST_METHOD']==='POST')
		{
			$username = trim($_POST['email']);
			$password = trim($_POST['password']);
			$civility = trim($_POST['civility']);
			$firstName = trim($_POST['firstName']);
			$lastName = trim($_POST['lastName']);
		

		$hash = password_hash($password, PASSWORD_BCRYPT);

		$customersManager = new CustomersManager();
		$idCustomer = $customersManager->addOne($username, $hash, $civility, $firstName, $lastName);
// var_dump($idCustomer);
		$customersManager->logIn($idCustomer, $username, $firstName);
// var_dump($_SESSION);die();
		header('Location:'.CLIENT_ROOT);
		exit();
		}
		else 
		{
			exit('403');
		}
	}
	
	public function authenticateAction()
	{
//var_dump($_POST);
// var_dump($_SESSION);
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);

			$customersManager = new CustomersManager();

			$customer = $customersManager->getOneByUsername($username);
//var_dump($customer);
			if($customer!==false && password_verify($password, $customer['hash']))
			{
				if(!isset($_SESSION['customer']['firstName']))
				{
					$customersManager->logIn($customer['id'], $customer['email'], $customer['firstName']);
// var_dump($_SESSION);
					header('Location:'.CLIENT_ROOT);
					exit();
				}
				else 
				{
					echo'Please log out !';
				}
				
			}
			else 
			{
				header('Location:'.CLIENT_ROOT.'customers/signIn/');
			}
		}
		else
		{
			exit('403');
		}	
	}

	public function signOutAction()
	{
		$customersManager = new CustomersManager();

		$customersManager->logOut();
		header('Location:'.CLIENT_ROOT);
	}
}























