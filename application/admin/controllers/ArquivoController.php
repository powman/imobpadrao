<?php
class Admin_ArquivoController extends Zend_Controller_Action {
	
	private $_model;
	
	public function init() {
		$this->_model = new Application_Model_ArquivoMapper ();
		$this->view->sucessMessage = '';
		$this->view->warningMessage = '';
	}
	
	public function indexAction() {
		$this->view->paginator = '';
		$aItens = array();		
		$pagina = intval($this->_getParam('pagina', 1));
				
		if ($this->getRequest ()->getParam ( 'id' ) !== null) {
			$this->_model->getDbTable ()->delete ( 'id=' . $this->getRequest ()->getParam ( 'id' ) );
			$this->view->sucessMessage = 'Arquivo excluído';
		}
		$aItens = $this->_model->fetchAll ();		
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
	
	public function cadastrarAction() {
		$request = $this->getRequest ();
		$form = new Application_Form_Arquivo ();
		$this->view->headerText = 'Cadastro de arquivo';
		$arquivo = new Application_Model_Arquivo ();
		if ($request->isPost ()) {
			if ($form->isValid ( $request->getPost () )) {
				$arquivo->setOptions ( $form->getValues () );
				$this->_model->save ( $arquivo );
				return $this->_helper->redirector ( 'index' );
			} else {
				$this->view->warningMessage = 'Alguns erros foram encontrado no formulário';
				$form->populate ( $request->getPost () );
			}
		} else if ($request->getParam ( 'id' ) !== null) {
			$this->view->headerText = 'Alterando arquivo';
			$this->_model->find ( $this->getRequest ()->getParam ( 'id' ), $arquivo );
			$data = array (
				'titulo' => $arquivo->getTitulo (), 
				'arquivo' => $arquivo->getArquivo ()  
			);
			$form->populate ( $data );
		}
		$this->view->form = $form;
	}


}