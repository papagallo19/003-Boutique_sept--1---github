<?php

class CustomersManager extends Manager 
{
	public function addOne($username, $hash, $civility, $firstName, $lastName)
	{

		$BDD = $this->getDataBaseConnection();

		$requete =
		'
			INSERT INTO 
				customers 
					(email, hash, civility, firstName, lastName )
			VALUES 
					(?,?,?,?,?)
		';

		$result = $BDD->prepare($requete);
		$result->execute([$username, $hash, $civility, $firstName, $lastName]);
		
		$idCustomer = $BDD->lastInsertId();

		return $idCustomer;
	}

	public function logIn($idCustomer, $username, $firstName)
	{
		if(session_status() !== PHP_SESSION_ACTIVE)
		{
			session_start();
		}
		session_regenerate_id();

		$_SESSION['customer'] = 
		[
			'id'=>$idCustomer,
			'username' => $username,
			'firstName'=>$firstName
		];
		// $_SESSION['user'] = [];

	}

	public function getOneByUsername($username)
	{
		$BDD = $this->getDataBaseConnection();
		//	Définition de la requête
		$requete =
		'
			SELECT
				id,
				email,
				hash,
				firstName,
				lastName
			FROM
				customers
			WHERE
				email = ?
		';
	
		$resultSet = $BDD->prepare($requete);
		$resultSet->execute([$username]);
		$customer = $resultSet->fetch();
		
		return $customer;
	}

	public function isAuthenticated()
	{
		if(session_status() !== PHP_SESSION_ACTIVE)
		{
			session_start();
		}
		session_regenerate_id();
		$isAuthenticated = array_key_exists('customer', $_SESSION);
		return $isAuthenticated;
	}

	public function getOneIsAuthenticated()
	{
		if(session_status() !== PHP_SESSION_ACTIVE)
		{
			session_start();
		}
		session_regenerate_id();
		$customer = $_SESSION['user'];
		//	Transmission de l'utilisateur authentifié
		return $customer;
	}

	public function logOut()
	{
		if($_SESSION !== PHP_SESSION_ACTIVE)
		{
			session_start();
		}
		session_regenerate_id();

		unset($_SESSION['customer']);
	}

}


































