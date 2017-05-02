<?php

class PaymentController extends PrivateAccessController
{
	public function authenticateAction()
	{
		$categories = $this->categories;
		$shoppingCart = $this->shoppingCart;

		$data = compact('categories', 'shoppingCart');

		new View ('shoppingCart/payment', $data);
	}
}