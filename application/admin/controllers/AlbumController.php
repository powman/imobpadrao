<?php

class Admin_AlbumController extends Zend_Controller_Action {

	private $_model;

	private $_sessionRef;

	public function init() {
		$this->_model = new Application_Model_AlbumMapper();
		$this->_modelConfig = new Application_Model_ConfigMapper();
		$this->view->sucessMessage = '';
		$this->view->warningMessage = '';
		Zend_Session_Namespace::resetSingleInstance('PluginFotoRef');
		$this->_sessionRef = new Zend_Session_Namespace('PluginFotoRef');
		$this->view->request = $this->_request; 
	}

	public function indexAction() {
		$this->view->paginator = '';
		$aItens = array();		
		$pagina = intval($this->_getParam('pagina', 1));
		
		
		if ($this->getRequest()->getParam('id') !== null) {
			$modelPlugin = new Application_Model_PluginMapper();
			$this->_model->deleteAlbum($this->getRequest()->getParam('id'));
			$modelPlugin->getDbTable()->delete('idPluginRef like \'' . $this->getRequest()->getParam('id') . '\'');
			$this->view->sucessMessage = 'Album excluído';
		}
		$aConfig = $this->_modelConfig->fetchAll('albumFixo = false');
		$this->view->entries = $aIdConfig = array();
		
		foreach ($aConfig as $config) {
			$aIdConfig[] = $config->getIdFotoConf();
		}
		if ($aIdConfig) {
			
			$aItens = $this->_model->fetchAll('idFotoConf in (' . join(',', $aIdConfig) . ')');		
			$paginator = Zend_Paginator::factory($aItens);
			// Seta a quantidade de registros por p�gina
			$paginator->setItemCountPerPage(10);
			// numero de paginas que ser�o exibidas
			$paginator->setPageRange(5);
			// Seta a p�gina atual
			$paginator->setCurrentPageNumber($pagina);
			// Passa o paginator para a view
			$this->view->entries = $paginator;
		}
	}

	public function cadastrarAction() {
		$request = $this->getRequest();
		$form = new Application_Form_Album();
		$this->view->headerText = 'Cadastro de album';
		$this->view->alterar = false;
		$album = new Application_Model_Album();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$album->setOptions($form->getValues());
				$this->_model->save($album);
				return $this->_helper->redirector('index');
			} else {
				$this->view->warningMessage = 'Alguns erros foram encontrado no formulário';
				$form->populate($request->getPost());
			}
		} else if ($request->getParam('idFotoAlbum') !== null) {
			$this->view->headerText = 'Alterando album';
			$this->view->alterar = true;
			$this->_model->find($this->getRequest()->getParam('idFotoAlbum'), $album);
			$data = array(
						'idFotoAlbum' => $album->getIdFotoAlbum(), 
						'idFotoConf' => $album->getIdFotoConf(), 
						'nomeAlbum' => $album->getNomeAlbum(), 
						'descricaoAlbum' => $album->getDescricaoAlbum(), 
						'idPluginRef' => $album->getIdPluginRef());
			$form->populate($data);
			$this->_sessionRef->idPluginRef = $album->getIdPluginRef();
			$this->_sessionRef->linkRef = array(
												'controller' => 'album', 
												'action' => 'cadastrar', 
												'module' => 'admin', 
												'idFotoAlbum' => $album->getIdFotoAlbum());
		}
		$this->view->form = $form;
	}
}