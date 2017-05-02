<?php

	abstract class Manager
	{
		const DSN = 'mysql:host=localhost;dbname=Shop';
		const USER_NAME = 'root';
		const PASSWORD = '';

		private $dataBaseConnection;

		protected function getDataBaseConnection()
		{
			if($this->dataBaseConnection === null)
			{
				$this->dataBaseConnection = new PDO
				(
					self::DSN,
					self::USER_NAME,
					self::PASSWORD,
					[
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
					]
				);
			}

			return $this->dataBaseConnection;
			 

		}
	}