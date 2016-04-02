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

	public function pay($paymentMethod, $ticketArr = array())
	{
		foreach ($ticketArr as $ticket)
		{
			$ticket->_setPaid(true);
			$ticket->_setPaymentMethod($paymentMethod);
		}
	}
}
