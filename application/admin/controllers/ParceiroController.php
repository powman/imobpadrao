<?php

class Admin_ParceiroController extends Zend_Controller_Action {

	private $_model;

	private $_uploaddir;

	public function init() {
		$this->_model = Application_Model_ParceiroMapper::instanciar();
		$this->view->sucessMessage = '';
		$this->view->warningMessage = '';
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/upload.ini');
		$this->_uploaddir = $config->uploaddir->parceiro->dir;
	}

	public function indexAction() {
		$this->view->paginator = '';
		$aItens = array();
		$pagina = intval($this->_getParam('pagina', 1));
		
		if ($this->getRequest()->getParam('id') !== null) {
			$parceiro = new Application_Model_Parceiro();
			$this->_model->find($this->getRequest()->getParam('id'), $parceiro);
			$this->_model->getDbTable()->delete('idParceiro=' . $this->getRequest()->getParam('id'));
			unlink($this->_uploaddir . $parceiro->getImagem());
			$this->view->sucessMessage = 'Parceiro excluído';
		}
		$aItens = $this->_model->fetchAll();
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

	public function incluirAction() {
		$request = $this->getRequest();
		$form = new Application_Form_Parceiro();
		$this->view->headerText = 'Cadastro de Parceiros';
		$parceiro = new Application_Model_Parceiro();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$parceiro->setOptions($form->getValues());
				if (!$parceiro->getIdParceiro() || $parceiro->getImagem()) {
					if($request->getParam('imagemOld')){
						unlink('media/imagens/parceiros/'.$request->getParam('imagemOld'));
					}
					$upload = new Zend_File_Transfer();
					$files = $upload->getFileInfo();
					$nomeParceiro = $this->alteranome($files['imagem']['name']);
					$upload->receive();					
					rename($this->_uploaddir.$files['imagem']['name'],$this->_uploaddir.$nomeParceiro);
					$parceiro->setImagem($nomeParceiro);								
					$parceiro->setExtensao($this->_findexts($files['imagem']['name']));
					
				}else{
					$parceiro->setImagem($request->getParam('imagemOld'));
					$parceiro->setExtensao($request->getParam('imagemOld'));
				}
				try {
					$this->_model->save($parceiro);
					return $this->_helper->redirector('index');
				} catch (Exception $e) {
					$this->view->warningMessage = 'Imagem já existente no servidor.';
				}
			} else {
				$this->view->warningMessage = 'Alguns erros foram encontrado no formulário';
				$form->populate($request->getPost());
				$this->view->imagem = $form->getValue('imagem');
			}
		} else if ($request->getParam('id') !== null) {
			$this->view->headerText = 'Alterando Parceiro';
			$this->_model->find($this->getRequest()->getParam('id'), $parceiro);
			$data = array(
						'idParceiro' => $parceiro->getIdParceiro(), 
						'nome' => $parceiro->getNome(), 
						'link' => $parceiro->getLink(), 
						'imagem' => $parceiro->getImagem(), 
						'imagemOld' => $parceiro->getImagem(),
						'extensao' => $parceiro->getExtensao(), 
						'status' => $parceiro->getStatus());
			$this->view->imagem = $parceiro->getImagem();
			$form->populate($data);
		}
		$this->view->form = $form;
	}

	private function _findexts($filename) {
		$filename = strtolower($filename);
		$exts = explode('.', $filename);
		$n = count($exts) - 1;
		$exts = $exts[$n];
		return $exts;
	}
	
	private function alteranome($filename) {
		$filename = strtolower($filename);
		$aExt = explode('.', $filename);
		$p = count($aExt) - 1;
		return 'file_' . time() . '.' . $aExt[$p];
	}
}