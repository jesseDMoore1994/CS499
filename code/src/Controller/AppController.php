<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

require_once(ROOT . DS . 'vendor' . DS  . 'theater-ticket' . DS . 'pbkdf2.php');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array('Cookie');

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if ($this->Cookie->read('ta_login_id') !== null) {
			$login_id = $this->Cookie->read('ta_login_id');
			$login_email = $this->Cookie->read('ta_login_email');
			$login_key = $this->Cookie->read('ta_login_key');

			$table = TableRegistry::get("Users");
			$user = $table->find('all')
				->where(["id" => $login_id, "email" => $login_email])->all();

			if ($user->count() > 0) {
				if ($user->first()->makeKey() == $login_key) {
					$this->loggedIn = true;
					$this->user = $user->first();
				} else {
					$this->loggedIn = true;
					$this->user = null;
				}
			}

			$this->set("loggedIn", $this->loggedIn);
			$this->set("me", $this->user);
		}

	}

	/**
	 * Before render callback.
	 *
	 * @param \Cake\Event\Event $event The beforeRender event.
	 * @return void
	 */
	public function beforeRender(Event $event) {
		if (!array_key_exists('_serialize', $this->viewVars) &&
			in_array($this->response->type(), ['application/json', 'application/xml'])
		) {
			$this->set('_serialize', true);
		}
	}
}
