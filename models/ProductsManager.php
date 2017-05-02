 <?php

class ProductsManager extends Manager
{
	

	public function getCountAll()
	{
		$BDD = $this->getDataBaseConnection();
		$requete = 
		'
			SELECT 
				COUNT(products.id)
			FROM 
				products 
		';

		$result = $BDD->query($requete);
		$numberProducts = $result->fetchColumn();

		return $numberProducts;
	}

	public function getAll($page = 1)
	{
		$BDD = $this->getDataBaseConnection();

		$requete =
		'
			SELECT 
				id,
				name,
				description,
				imagePath,
				ROUND(priceHT*(1+ VATRate/100)) AS priceTTC 
			FROM 
				products 
			ORDER BY 
				name 
			LIMIT 
				?, ?
		';

		$result = $BDD->prepare($requete);
		$result->bindValue(1, ($page - 1) * ProductsController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		$result->bindValue(2, ProductsController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		$result->execute();
		$products = $result->fetchAll();

		return $products;

	}

	public function getOne($id)
	{
		$BDD = $this->getDataBaseConnection();

		$requete = 
		'
			SELECT 
				id,
				name,
				description,
				imagePath,
				ROUND(priceHT*(1 + VATRate/100)) AS priceTTC 
			FROM 
				products
			WHERE 
				id = ?
		';

		$result = $BDD->prepare($requete);
		$result->execute([$id]);

		$product = $result->fetch();

		return $product;

	}

	public function getCountByCategory($idCategory)
	{
		$BDD = $this->getDatabaseConnection();

		$requete =
		'
			SELECT 
				COUNT(id)
			FROM 
				products 
			WHERE 
				idCategory = ?
		';

		$result = $BDD->prepare($requete);
		$result->execute([$idCategory]);
		$numberProducts = $result->fetchColumn();

		return $numberProducts;
	}

	public function getAllByCategory($idCategory, $page=1)
	{
		$BDD = $this->getDatabaseConnection();

		$requete =
		'
			SELECT 
				products.id,
				products.name,
				products.description,
				products.imagePath,
				ROUND(priceHT*(1 + VATRate/100)) AS priceTTC
				
			FROM 
				products 
			
			WHERE 
				idCategory = ?
			ORDER BY 
				name
			LIMIT 
				?, ? 
		';

		$result = $BDD->prepare($requete);
		$result->bindValue(1, $idCategory, PDO::PARAM_INT); 
		$result->bindValue(2, ($page-1)*productsController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		$result->bindValue(3, productsController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		$result->execute();

		$products = $result->fetchAll();
		return $products;
	}

	public function getCountBySearch($search)
	{
		$BDD = $this->getDatabaseConnection();

		$requete =
		'
			SELECT 
				COUNT(id)
			FROM 
				products
			WHERE 
				name LIKE ?
		';

		$result = $BDD->prepare($requete);
		$result->execute(['%'.$search.'%']);
		$numberProducts = $result->fetchColumn();
		return $numberProducts;
	}

	public function getBySearch($search, $page=1){
		$BDD = $this->getDataBaseConnection();

		$requete =
		'
			SELECT 
				products.id,
				products.name,
				products.description,
				products.imagePath,
				ROUND(priceHT*(1 + VATRate/100)) AS priceTTC
			FROM 
				products 
			WHERE 
				name LIKE ?
			ORDER BY 
				name 
			LIMIT 
				?, ?
		';

		$result = $BDD->prepare($requete);
		$result->bindValue(1, '%'.$search.'%', PDO::PARAM_STR);
		$result->bindValue(2, ($page-1)*ProductsController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		$result->bindValue(3, ProductsController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		$result->execute();
		$products = $result->fetchAll();
		return $products;
	}


	public function getByIds(array $ids)
	{

		$BDD = $this->getDataBaseConnection();
		
		//	Si aucun identifiant n'est transmis
			if(count($ids) < 1)
			{
				//	Transmission de l'absence de produit (tableau vide)
				return [];
			}
			
		$requete =
		'
			SELECT 
				id,
				name,
				description,
				imagePath,
				priceHT,
				VATRate,
				(priceHT*(1 + VATRate/100)) AS priceTTC
			FROM 
				products 
			WHERE 
				id IN ('.implode(',', array_fill(0, count($ids), '?')).')
			ORDER BY 
				id DESC
		';
		

		$result = $BDD->prepare($requete);
		$counter=1;
		if(count($ids)<0)
		{
			header('Location: '. CLIENT_ROOT.'./');
		}
		else
		{
			foreach($ids as $index => $id)
			
			{
				$result->bindValue($counter++, $id, PDO::PARAM_INT);
			}
			$result->execute();

			$products = $result->fetchAll();
			return $products;
		}		
	}
}





















