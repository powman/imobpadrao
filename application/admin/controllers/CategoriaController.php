<?php

class Admin_CategoriaController extends Zend_Controller_Action {

	private $_model;

	private $_uploaddir;

	public function init() {
		$this->_model = Application_Model_CategoriaMapper::instanciar();
		$this->view->sucessMessage = '';
		$this->view->warningMessage = '';
	}

	public function indexAction() {
		$this->view->paginator = '';
		$aItens = array();
		$pagina = intval($this->_getParam('pagina', 1));
		
		if ($this->getRequest()->getParam('id') !== null) {
			$categoria = new Application_Model_Categoria();
			$this->_model->find($this->getRequest()->getParam('id'), $categoria);
			$this->_model->getDbTable()->delete('idCategoria=' . $this->getRequest()->getParam('id'));
			$this->view->sucessMessage = 'Categoria excluída';
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
		$form = new Application_Form_Categoria();
		$this->view->headerText = 'Cadastro de Categorias';
		$categoria = new Application_Model_Categoria();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$categoria->setOptions($form->getValues());
				$categoria->setCategoria(implode(',', $form->getValue('categoria')));
				$categoria->setIdTipoImovel($form->getValue('idTipoImovel'));
				$categoria->setOrdem($form->getValue('ordem'));
				try {
					$this->_model->save($categoria);
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
			$this->view->headerText = 'Alterando Categoria';
			$this->_model->find($this->getRequest()->getParam('id'), $categoria);
			$data = array(
						'idCategoria' => $categoria->getIdCategoria(), 
						'nome' => $categoria->getNome(), 
						'categoria' => explode(",",$categoria->getCategoria()), 
						'idTipoImovel' => explode(",",$categoria->getIdTipoImovel()), 
						'ordem' => $categoria->getOrdem(), 
						'status' => $categoria->getStatus());
			$form->populate($data);
		}
		$this->view->form = $form;
	}
}