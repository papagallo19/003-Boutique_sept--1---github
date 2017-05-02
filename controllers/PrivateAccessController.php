<?php

	class PrivateAccessController extends CommonController
	{
		
		public function __construct()
		{
			parent::__construct();
			
			$customersManager = new CustomersManager();

			if(!$customersManager->isAuthenticated())
			{
				header('Location: '.CLIENT_ROOT.'customers/signIn/');
				exit();
			}

		}
	}