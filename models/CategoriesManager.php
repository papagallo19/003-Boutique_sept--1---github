<?php

class CategoriesManager extends Manager
{
	

	public function getAll()
	{
		$requete = 
		'
			SELECT 
				categories.id,
				categories.name,
				COUNT(products.id) AS numberProducts 
			FROM 
				categories 
			INNER JOIN 
				products 
			ON 
				categories.id = products.idCategory 
			GROUP BY 
				categories.id
		';

		$result = $this->getDataBaseConnection()->query($requete);
		$categories = $result->fetchAll();

		return $categories;

	}
	public function getOne($idCategory)
	{
		$requete = 
		'
			SELECT 
				categories.id,
				categories.name,
				COUNT(products.id) AS numberProducts
			FROM 
				categories 
			INNER JOIN 
				products 
			ON 
				categories.id = products.idCategory
			WHERE 
				categories.id = ?
		';

		$result = $this->getDataBaseConnection()->prepare($requete);
		$result->execute([$idCategory]);
		$category = $result->fetch();
		return $category ;
	}
	
}