<?php
namespace App\Controller;

use App\Controller\AppController;

class AuthController extends AppController
{
	public function index()
	{
		$this->redirect('/auth/login/');
	}

	public function login()
	{
		$this->viewBuilder()->layout("auth");
	}

	public function signup()
	{
		$this->viewBuilder()->layout("auth");
	}
}
