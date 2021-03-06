<?php

require_once('View/View.php');
require_once('Model/Admin.php');
require_once('Model/Bill.php');
require_once('Model/Comments.php');

class adminController {

	private $_Admin;

	public function __construct() {
		$this->_Admin = new Admin();
	}	

//PAGES

	//PANEL DE CONNECTION
	public function connection() {
		$view = new View('Connection', 'Frontend');
		$view->generate(array(), 'Frontend');
	}

	//SUCCES
	public function success($message, $side) {
		$view = new View('Success', $side);
		$view->generate(array('msg' => $message), $side);
	}

	//ERREUR
	public function error($message, $side) {
		$view = new View('Error', $side);
		$view->generate(array('msg' => $message), $side);
	}

//TESTS

	//CHECK DONNEES D'ADMINISTRATEUR
	public function checkAdmin($account, $password) {
		$req = $this->_Admin->isAdminAccount($account);
		$result = $req->fetch();

		$passComp = password_verify($password, $result['p']);

		if ($passComp) {
			return true;
		} else {
			return false;
		}
	}

//FONCTIONNALITES

	//(RE)CREATION DE SESSION
	public function session() {
		if (isset($_COOKIE['account']) && isset($_COOKIE['password'])) {
			if (!empty($_COOKIE['account']) && !empty($_COOKIE['password'])) {
				if ($this->checkAdmin($_COOKIE['account'], $_COOKIE['password'])) {
					session_start();
					$this->connectAdminAccount($_COOKIE['account'], $_COOKIE['password']);
				} else {
					$this->disconnect();					
					$this->error("Ce compte est inconnu");
				}
			}
		}		
		if (!isset($_SESSION)) {
			session_start();									
		}
		if (isset($_POST['disconnect']) && $_POST['disconnect'] === 'disconnect') {
			$this->disconnect();
		}
	}

	//CREATION DE DONNEES DE SESSION & COOKIES
	public function connectAdminAccount($account, $password, $stay = 0) {
		$req = $this->_Admin->isAdminAccount($account);
		$result = $req->fetch();

		if (isset($_SESSION)) {
			$_SESSION['pseudo'] = $result['pseudo'];
			$_SESSION['account'] = $result['ac'];
			$_SESSION['password'] = $password;
		}		

		if ($stay !== 0) {
			setcookie('pseudo', $_SESSION['pseudo'], time() + 365*24*3600);		
			setcookie('account', $_SESSION['account'], time() + 365*24*3600);
			setcookie('password', $_SESSION['password'], time() + 365*24*3600);		
		}
	}	

	//DECONNECTION
	public function disconnect() {
		foreach ($_COOKIE as $key => $value) {
			setcookie($key, '', time() - 365*24*3600, '/');		
			setcookie($key, '', time() - 365*24*3600);
			unset($_COOKIE[$key]);
		}
		if (isset($_SESSION)) {
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			session_destroy();
		}		
	}
	
}
