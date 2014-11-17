<?php

class Admin_ImovelController extends Zend_BaseController {
	
	public function init(){
		$pagina = intval ( $this->_getParam ( 'pagina', 1 ) );
		$imovelMapper = Application_Model_ImovelMapper::instanciar();
		$aImovel = $imovelMapper->fetchAll();
		
		$paginator = Zend_Paginator::factory ( $aImovel );
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
		$this->view->aImovel = $paginator;
				  
	}
	public function indexAction() {
		$imovelMapper = Application_Model_ImovelMapper::instanciar();
		$this->view->paginator = '';
		$aItens = array();		
		$pagina = intval($this->_getParam('pagina', 1));
				
		$form = new Application_Form_BuscaImovel();
		$request = $this->getRequest ();
		$this->view->form = $form;		
		$sWhere = null;		
		
		if ($request->isPost ()) {
			if ($form->isValid ( $request->getPost () )) {
				$idImovel = $form->getValue ('idimovel');
				if($idImovel){
					if(is_numeric($idImovel)){
						$sWhere = 'idimovel = '.$idImovel;
					}else{
						$this->_helper->FlashMessenger(array('warning' => 'Código inválido.'));
					}	
				}else{
					$this->_helper->FlashMessenger(array('warning' => 'Você deve digitar um código.'));
				}	
			}
		}		
			$aItens = $imovelMapper->fetchAll ($sWhere);
			if(!$aItens){
				$this->_helper->FlashMessenger(array('warning' => 'Nenhum imóvel encontrado.'));
			}			
		
			$paginator = Zend_Paginator::factory($aItens);
			// Seta a quantidade de registros por p�gina
			$paginator->setItemCountPerPage(10);
			// numero de paginas que ser�o exibidas
			$paginator->setPageRange(5);
			// Seta a p�gina atual
			$paginator->setCurrentPageNumber($pagina);
			// Passa o paginator para a view
			$this->view->aImovel = $paginator;			
		}
}