<?php

class Admin_BannerController extends Zend_Controller_Action {

	private $_model;

	private $_uploaddir;

	public function init() {
		$this->_model = Application_Model_BannerMapper::instanciar();
		$this->view->sucessMessage = '';
		$this->view->warningMessage = '';
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/upload.ini');
		$this->_uploaddir = $config->uploaddir->banner->dir;
	}

	public function indexAction() {
		$this->view->paginator = '';
		$aItens = array();
		$pagina = intval($this->_getParam('pagina', 1));
		
		if ($this->getRequest()->getParam('id') !== null) {
			$banner = new Application_Model_Banner();
			$this->_model->find($this->getRequest()->getParam('id'), $banner);
			$this->_model->getDbTable()->delete('idBanner=' . $this->getRequest()->getParam('id'));
			unlink($this->_uploaddir . $banner->getImagem());
			$this->view->sucessMessage = 'Banner excluído';
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
		$form = new Application_Form_Banner();
		$this->view->headerText = 'Cadastro de banner';
		$banner = new Application_Model_Banner();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$banner->setOptions($form->getValues());
				if (!$banner->getIdBanner() || $banner->getImagem()) {
					if($request->getParam('imagemOld')){
						unlink('media/imagens/banners/'.$request->getParam('imagemOld'));
					}
					$upload = new Zend_File_Transfer();
					$files = $upload->getFileInfo();
					$nomeBanner = $this->alteranome($files['imagem']['name']);
					$upload->receive();					
					rename($this->_uploaddir.$files['imagem']['name'],$this->_uploaddir.$nomeBanner);
					$banner->setImagem($nomeBanner);								
					$banner->setExtensao($this->_findexts($files['imagem']['name']));
				}else{
					$banner->setImagem($request->getParam('imagemOld'));
					$banner->setExtensao($request->getParam('imagemOld'));
				}
				try {
					$this->_model->save($banner);
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
			$this->view->headerText = 'Alterando banner';
			$this->_model->find($this->getRequest()->getParam('id'), $banner);
			$data = array(
						'idBanner' => $banner->getIdBanner(), 
						'nome' => $banner->getNome(), 
						'link' => $banner->getLink(), 
						'imagem' => $banner->getImagem(),
						'imagemOld' => $banner->getImagem(),
						'extensao' => $banner->getExtensao(), 
						'status' => $banner->getStatus());
			$this->view->imagem = $banner->getImagem();
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