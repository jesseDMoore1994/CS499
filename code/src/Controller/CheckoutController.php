<?php
namespace App\Controller;

use App\Controller\AppController;

class CheckoutController extends AppController
{
	public function index()
	{
		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);
	}
}
