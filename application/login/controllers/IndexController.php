<?php

class Login_IndexController extends Zend_Controller_Action {

	protected $_flashMessenger = null;

	public function init() {
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
	}

	public function indexAction() {
		$this->view->warningMessage = $this->_flashMessenger->getMessages();
	}

	public function loginAction() {		
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		//Verifica se existem dados de POST
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			$filter = new Zend_Filter_StripTags();
			//Formulário corretamente preenchido?
			$login = $filter->filter($this->_request->getPost('usuario'));
			$senha = $filter->filter($this->_request->getPost('senha'));
			
			$dbAdapter = Zend_Db_Table::getDefaultAdapter();
			//Inicia o adaptador Zend_Auth para banco de dados
			$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
			$authAdapter->setTableName('usuario')->setIdentityColumn('login')->setCredentialColumn('senha')->setCredentialTreatment('MD5(?)');
			//Define os dados para processar o login
			$authAdapter->setIdentity($login)->setCredential($senha);
			//Efetua o login
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($authAdapter);
			//Verifica se o login foi efetuado com sucesso
			if ($result->isValid()) {
				//Armazena os dados do usuário em sessão, apenas desconsiderando
				//a senha do usuário
				$info = $authAdapter->getResultRowObject(null, 'senha');
				$storage = $auth->getStorage();
				$storage->write($info);
				//Redireciona para o Controller protegido
				return $this->_helper->redirector->goToRoute ( array('controller' => 'index', 'module' => 'admin'), 
																			null, true);
			} else {
				//Dados inválidos
				$this->_helper->FlashMessenger('Usuário ou senha inválidos!');
				$this->_redirect('/login/');
			}
		}
	
	}

	public function logoutAction() {
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		Zend_Registry::_unsetInstance();
		Zend_Session::destroy();
		return $this->_helper->redirector('index');
	}

}

