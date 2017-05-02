<?php

class OrdersManager extends Manager
{
	public function saveOne($billingInformation, $deliveryInformation, $shoppingCart, $idCustomer)
	{
		$BDD = $this->getDataBaseConnection();
		// Cette fonction sert à enregistrer la commande dans la base de données
		$requete = 
		'
			INSERT INTO 
				orders 
					(purchaseDate, billingCivility, billingFirstName, billingLastName, billingAddress, billingZipCode, billingCity, billingCountry, billingPhoneNumber, deliveryCivility, deliveryFirstName, deliveryLastName, deliveryAddress, deliveryZipCode, deliveryCity, deliveryCountry, deliveryPhoneNumber, idCustomer)
			VALUES 
				(NOW(), ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?)
		';

		$result = $BDD->prepare($requete);
		$result->bindValue(1, $billingInformation['civilite']);
		$result->bindValue(2, $billingInformation['prenom']);
		$result->bindValue(3, $billingInformation['nom']);
		$result->bindValue(4, $billingInformation['adresse']);
		$result->bindValue(5, $billingInformation['codePostal']);
		$result->bindValue(6, $billingInformation['commune']);
		$result->bindValue(7, $billingInformation['pays']);
		if(!isset($billingInformation['telephone']))
		{
			$result->bindValue(8, null, PDO::PARAM_NULL);
		}
		else 
		{
			$result->bindValue(8, $billingInformation['telephone'], PDO::PARAM_INT);
		}
		$result->bindValue(9, $deliveryInformation['civilite']);
		$result->bindValue(10, $deliveryInformation['prenom']);
		$result->bindValue(11, $deliveryInformation['nom']);
		$result->bindValue(12, $deliveryInformation['adresse']);
		$result->bindValue(13, $deliveryInformation['codePostal']);
		$result->bindValue(14, $deliveryInformation['commune']);
		$result->bindValue(15, $deliveryInformation['pays']);
		if(!isset($deliveryInformation['telephone']))
		{
			$result->bindValue(16, null, PDO::PARAM_NULL);
		}
		else 
		{
			$result->bindValue(16, $deliveryInformation['telephone'], PDO::PARAM_INT);
		}
		$result->bindValue(17, $idCustomer);

		$result->execute();

		$idOrder = $BDD->lastInsertId();
// var_dump($shoppingCart); 
		foreach($shoppingCart as $orderLine)
		{
			$this->saveOrderLine($orderLine, $idOrder);
		}

	}

	public function saveOrderLine(array $orderLine, $idOrder)
	{
		$BDD = $this->getDataBaseConnection();

		$requete = 
		'
			INSERT INTO 
				orderlines
					(idOrder, idProduct, quantity, nameProduct, priceHT, VATRate)
			VALUES 
				(?,?,?,?,?,?)
		';

		$result = $BDD->prepare($requete);

		$result->bindValue(1, $idOrder);
		$result->bindValue(2, $orderLine['id']);
		$result->bindValue(3, $orderLine['quantity']);
		$result->bindValue(4, $orderLine['name']);
		$result->bindValue(5, $orderLine['priceHT']);
		$result->bindValue(6, $orderLine['VATRate']);



	}
}






























