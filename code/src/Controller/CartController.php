<?php
namespace App\Controller;

use App\Controller\AppController;

class CartController extends AppController
{
	public function index()
	{
		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		// Load the cart contents
		$cart = [
			[15, "The Tragedy of Othello, the Moor", "Civil Center Playhouse", "January 1st, 2016", "10:00 PM", "F12"],
			[15, "The Tragedy of Othello, the Moor", "Civil Center Playhouse", "January 1st, 2016", "10:00 PM", "F13"],
		];

		// Add up the cart total
		$pre_tax = 0;
		foreach ($cart as $item) { $pre_tax += $item[0]; }

		// Compute Tax
		$tax = $pre_tax * 0.09;

		// Pass the cart and total to the view
		$this->set("cart", $cart);
		$this->set("pre_tax", $pre_tax);
		$this->set("tax", $tax);
		$this->set("total", $pre_tax + $tax);
	}
}
