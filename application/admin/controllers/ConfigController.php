<?php
class Admin_ConfigController extends Zend_Controller_Action {
	
	private $_model;
	
	public function init() {
		$this->_model = new Application_Model_ConfigMapper ();
		$this->view->sucessMessage = '';
		$this->view->warningMessage = '';
	}
	
	public function indexAction() {
		$this->view->paginator = '';
		$aItens = array();		
		$pagina = intval($this->_getParam('pagina', 1));
				
		$aItens = $this->_model->fetchAll ();		
		$paginator = Zend_Paginator::factory($aItens);
		// Seta a quantidade de registros por página
		$paginator->setItemCountPerPage(10);
		// numero de paginas que serão exibidas
		$paginator->setPageRange(5);
		// Seta a página atual
		$paginator->setCurrentPageNumber($pagina);
		// Passa o paginator para a view
		$this->view->entries = $paginator;	
	}
	
	public function cadastrarAction(){
		$form = new Application_Form_Config();
		$this->view->form = $form;
	}

}