<?php

class Admin_IndexController extends Zend_Controller_Action {

	public function init() {
	}

	public function indexAction() {
		
		$auth = Zend_Auth::getInstance()->getIdentity();
		$menuPermissao = Application_Model_PermissaoMapper::instanciar();
		$menuModulo = Application_Model_ModuloMapper::instanciar();
		if ($auth->idPerfil != 1) {
			$this->view->entries = $menuPermissao->fetchAll('idPerfil = ' . $auth->idPerfil);
		} else {
			$this->view->entries = $menuModulo->fetchAll();
		}
	}

}

