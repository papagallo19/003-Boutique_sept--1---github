<?php 

class DefaultController extends Controller{

	public function defaultAction(){

		(new ProductsController())->showAllAction();
	}
}