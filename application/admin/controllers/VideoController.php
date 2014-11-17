<?php

class Admin_VideoController extends Zend_BaseController {
	
	private $imovel;	

	public function init() {
		Zend_Session::start ();
		$busca = new Zend_Session_Namespace ( 'imovel' );
		if ($this->_request->getParam('imovel')) {
			$busca->unsetAll ();
			$busca->imovel = $this->_request->getParam('imovel');
		}
		$this->imovel = ($busca->imovel) ? $busca->imovel : 0;
	}
	
	public function indexAction() {
		$request = $this->getRequest ();
		$idImovel = $this->imovel;
		
		/**
		 * Busca as descri��es do im�vel 
		 */
		$imovelMapper = Application_Model_ImovelMapper::instanciar ();
		$imovelModel = new Application_Model_Imovel ();
		$imovelMapper->find ( $idImovel, $imovelModel );
		$this->view->aImovel = $imovelModel;
		
		/**
		 * Busca os v�deos cadastrados no im�vel em quest�o 
		 */
		$pagina = intval ( $this->_getParam ( 'pagina', 1 ) );
		$videos_mapper = Application_Model_VideoMapper::instanciar ();
		$aVideos = $videos_mapper->fetchAll ( 'idimovel = ' . $idImovel );
		
		$paginator = Zend_Paginator::factory ( $aVideos );
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
		$this->view->aVideos = $paginator;
	}
	
	public function cadastrarAction() {
		$request = $this->getRequest ();
		$form = new Application_Form_Video ();
		$form->populate ( array ('idimovel' => $this->imovel ) );
		$this->view->headerText = 'Cadastro de vídeos';
		$video = new Application_Model_Video ();
		$videoMapper = Application_Model_VideoMapper::instanciar ();
		if ($request->isPost ()) {
			if ($form->isValid ( $request->getPost () )) {
				$video->setOptions ( $form->getValues () );
				$videoMapper->save ( $video );
				$this->_helper->FlashMessenger ( "Video cadastrado com sucesso" );
				return $this->_helper->redirector ( 'index', 'video', 'admin');
			} else {
				$aParam = array ('warning' => 'Alguns erros foram encontrado no formulário' );
				$this->_helper->FlashMessenger ( $aParam );
				$form->populate ( $request->getPost () );
			}
		} else if ($request->getParam ( 'idVideo' ) !== null) {
			$data = array ('idimovel' => $video->getIdImovel (), 'titulo' => $video->getTitulo (), 'ativo' => $video->getAtivo (), 'video' => $video->getVideo () );
			$form->populate ( $data );
		}
		$this->view->form = $form;
	
	}
	
	public function alterarAction() {
		$this->_form = new Application_Form_Video ();
		$this->_mapper = Application_Model_VideoMapper::instanciar ();
		$this->_model = new Application_Model_Video ();
		
		if ($this->getRequest ()->getParam ( 'id' ) == null) {
			$this->_helper->FlashMessenger ( array ('error' => 'Código do vídeo não informado.' ) );
			return $this->_helper->redirector ( 'index' );
		
		}
		$this->view->headerText = 'Alterando vídeo';
		if ($this->getRequest ()->isPost ()) {
			if ($this->_form->isValid ( $this->getRequest ()->getPost () )) {
				try {
					$this->gravarAction ();
					$this->_helper->FlashMessenger ( $this->_labelController . ' alterado.' );
				} catch ( Exception $e ) {
					$this->_helper->FlashMessenger ( array ('error' => $e->getMessage () ) );
				}
			} else {
				$this->_helper->FlashMessenger ( array ('warning' => 'Alguns erros foram encontrado no formulário.' ) );
			}
			if ($this->_debug)
				print_rpre ( $this->_form->getValues () );
		} else {
			$this->_mapper->find ( $this->getRequest ()->getParam ( 'id' ), $this->_model );
			$this->_form->populate ( $this->_model->toArray () );
		}
		$this->view->form = $this->_form;
		$this->view->model = $this->_model;
	}
	
	public function excluirAction() {
		$videoMapper = Application_Model_VideoMapper::instanciar();			
		
		if ($this->getRequest()->getParam('id') == null) {
			$aParam = array('error' => 'Código do ' . strtolower($this->_labelController) . ' não informado.');
			$this->_helper->FlashMessenger($aParam);
			return $this->_helper->redirector('index');		
		}
		
		try {
			$del = $videoMapper->getDbTable()->delete('id' . $videoMapper->_name . '=' . $this->getRequest()->getParam('id'));
			if (!$del)
				throw new Exception($this->_labelController . ' não encontrado.');
			$this->_helper->FlashMessenger($this->_labelController . ' excluído.');
			return $this->_helper->redirector('index');
		} catch (Exception $e) {
			$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
			return $this->_helper->redirector('index');
		}
	}
}