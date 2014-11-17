<?php

class ServicosController extends Zend_Controller_Action {
	
	
	public function init() {
		$this->parceiros = Application_Model_ParceiroMapper::instanciar();
		
		/**
		 * Carregar tipos de imóvel cadastrados
		 * para criar formulário de busca
		 */
		$aParceiro = array();
		$aParceiro = $this->parceiros->fetchAll();
		$this->view->aParceiro = $aParceiro;
		
		$this->view->metapalavrachave = Zend_Registry::get('metaPgServicoChave');
		$this->view->metadescricao = Zend_Registry::get('metaPgServicoDescricao');
		$this->view->metatitle = Zend_Registry::get('metaPgServicoTitle');
	}
	
	public function indexAction() {
		
	}
	

}