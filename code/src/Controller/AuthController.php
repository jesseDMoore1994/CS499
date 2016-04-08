<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

require_once(ROOT . DS . 'vendor' . DS  . 'theater-ticket' . DS . 'pbkdf2.php');

class AuthController extends AppController
{

	public function index()
	{
		$this->redirect('/auth/login/');
	}

	public function login()
	{
		$this->viewBuilder()->layout("auth");

		if ($this->request->is('post')) {
			$email = $this->request->data("email");
			$password = $this->request->data("password");

			$table = TableRegistry::get('Users');
			$users = $table->find()->where(["email" => $email])->all();

			if ($users->count() > 0) {
				$user = $users->first();
				$hash = pbkdf2("sha256", $password, $user->salt);

				if ($hash == $user->password) {
					$key = $user->makeKey();
					$this->Cookie->write('ta_login_id', $user->id);
					$this->Cookie->write('ta_login_email', $user->email);
					$this->Cookie->write('ta_login_key', $key);
					return $this->redirect("/");
				}
			}

			$this->Flash->set("The email and/or password you entered are not valid.", [
				'element' => 'error'
			]);

		}
	}

	public function logout()
	{
		$this->Cookie->write('ta_login_id', "0");
		$this->Cookie->write('ta_login_email', "");
		$this->Cookie->write('ta_login_key', "");
		return $this->redirect("/");
	}

	public function signup()
	{
		if ($this->request->is('post')) {
			$table = TableRegistry::get('Users');

			$salt = uniqid(mt_rand(), true);

			$user = $table->newEntity([
				'name' => $this->request->data('name'),
				'email' => $this->request->data('email'),
				'password' => pbkdf2("sha256", $this->request->data('password'), $salt),
				'salt' => $salt,
				'date_created' => Time::createFromTimestamp(time())
			]);

			if ($user->isValid() && $this->request->data('password') == $this->request->data('confirm_password') && $table->save($user)) {

				$key = $user->makeKey();

				$this->Cookie->write('ta_login_id', $user->id);
				$this->Cookie->write('ta_login_email', $user->email);
				$this->Cookie->write('ta_login_key', $key);
				return $this->redirect("/");

			} else {
				if ($user->isValid()) {
					if ($this->request->data('password') == $this->request->data('confirm_password')) {
						$this->Flash->set('The email you entered is already in use.', [
							'element' => 'error'
						]);
					} else {
						$this->Flash->set('The password and confirmation you entered did not match.', [
							'element' => 'error'
						]);
					}
				} else {
					$this->Flash->set('Please make sure your email is valid and name is longer than three characters.', [
						'element' => 'error'
					]);
				}
			}
		}

		$this->viewBuilder()->layout("auth");
	}

	public function forgot()
	{
		$this->viewBuilder()->layout("auth");
	}
}
