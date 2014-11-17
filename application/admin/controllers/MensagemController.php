<?php

class Admin_MensagemController extends Zend_BaseController {

	public function init() {
		$this->_nmController = ucfirst($this->_request->getControllerName());
		$this->_labelController = ($this->_labelController) ? $this->_labelController : $this->_nmController;
		
		$sModel = 'Application_Model_' . $this->_nmController;
		$this->_model = new $sModel();
		
		$sMapper = $sModel . 'Mapper';
		$this->_mapper = call_user_func(array($sMapper, 'instanciar'));
	}

	public function indexAction() {
		$pagina = intval ( $this->_getParam ( 'pagina', 1 ) );
		$mensagemMapper = Application_Model_MensagemMapper::instanciar();
		$aMsg = $mensagemMapper->fetchAll(null, 'idMensagem desc');
		
		$paginator = Zend_Paginator::factory ( $aMsg );
		/**
		 * Seta a quantidade de registros por p�gina
		 */
		$paginator->setItemCountPerPage ( 5 );
		/**
		 * numero de paginas que ser�o exibidas
		 */
		$paginator->setPageRange ( 5 );
		/**
		 * Seta a p�gina atual
		 */
		$paginator->setCurrentPageNumber ( $pagina );
		/**
		 * Passa o paginator para a view
		 */
		
		$this->view->entries = $paginator;
	}

	public function cadastrarAction() {
		if ($this->getRequest()->getParam('id')) {
			$paramId = $this->getRequest()->getParam('id');
			$msgMapper = Application_Model_MensagemMapper::instanciar();
			$msgMapper->find($paramId, $this->_model);
			$this->view->aMensagem = $this->_model;
			$data['status'] = 1;
			$this->_mapper->getDbTable()->update($data, 'idMensagem = '. $paramId);
		} else {
			$this->_helper->FlashMessenger(array('error' => 'Erro ao abrir a mensagem.'));
			return $this->_helper->redirector('index', $this->_request->getControllerName(), $this->_request->getModuleName());
		}
	}
	
	public function excluirAction() {
		if ($this->getRequest()->getParam('id') == null) {
			$aParam = array('error' => 'Código da ' . strtolower($this->_labelController) . ' não informada.');
			$this->_helper->FlashMessenger($aParam);
			return $this->_helper->redirector('index');
		}
		
		try {
			$del = $this->_mapper->getDbTable()->delete('id' . $this->_mapper->_name . '=' . $this->getRequest()->getParam('id'));
			if (!$del)
				throw new Exception($this->_labelController . ' não encontrada.');
			$this->_helper->FlashMessenger($this->_labelController . ' excluída.');
			return $this->_helper->redirector('index');
		} catch (Exception $e) {
			$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
			return $this->_helper->redirector('index');
		}
	}
}
