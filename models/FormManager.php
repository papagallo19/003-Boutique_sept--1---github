<?php 

class FormManager  
{
	public function __construct()
	{
		if(session_status() !== PHP_SESSION_ACTIVE)
		{
			session_start();
		}
		session_regenerate_id();

		if(!isset($_SESSION['form']))
		{
			$_SESSION['form']=[];
		}
	}	

	public function getAll($form)
	{
		// Ici je veux récupérer les infos et les erreurs. 
		// les infos sont dans la SESSION. Je vais récupérer un tableau $formInformation avec les errors et le data.

		if(isset($_SESSION['form'][$form]['errors']))
		{
			$formInformation['errors'] = $_SESSION['form'][$form]['errors'];
		}
		else 
		{
			$formInformation['errors'] = [];
		}

		if(isset($_SESSION['form'][$form]['data']))
		{
			$formInformation['data'] = $_SESSION['form'][$form]['data'];
		}
		else 
		{
			$formInformation['data'] = [];
		}

		return $formInformation;

	}

	// Enregistrement des données correctes
	public function saveData(array $formData, $form)
	{
		$_SESSION['form'][$form]['data'] = $formData;
		return $formData;
	}

	// Enregistrement des erreurs 
	public function saveErrors(array $formErrors, $form)
	{
		$_SESSION['form'][$form]['errors'] = $formErrors;
	}
}

























