<?php

abstract class Zend_BaseController extends Zend_Controller_Action {

	/**
	 * Mapper para utilização no formulário.
	 * @var Application_Model_BaseMapper
	 */
	protected $_mapper;

	/**
	 * Model para utilização no formulário.
	 * @var Application_Model_BaseMapper
	 */
	protected $_model;

	/**
	 * Formulario utilizado.
	 * @var Zend_Dojo_Form or Zend_Form
	 */
	protected $_form;

	/**
	 * Nome do controller
	 * @var Application_Model_BaseMapper
	 */
	protected $_nmController;

	/**
	 * Label do controller
	 * @var Application_Model_BaseMapper
	 */
	protected $_labelController;

	/**
	 * Habilita o debug do formulário 
	 * @var boolean
	 */
	protected $_debug = false;

	/**
	 * Função onde deve se configurar as opções do controller.
	 * @see Zend_Controller_Action::init()
	 */
	public function init() {
		$this->_nmController = ucfirst($this->_request->getControllerName());
		$this->_labelController = ($this->_labelController) ? $this->_labelController : $this->_nmController;
		
		$sModel = 'Application_Model_' . $this->_nmController;
		$this->_model = new $sModel();
		
		$sMapper = $sModel . 'Mapper';
		$this->_mapper = call_user_func(array($sMapper, 'instanciar'));
		
		$sForm = 'Application_Form_' . $this->_nmController;
		$this->_form = new $sForm();
		
		$this->_debug = (APPLICATION_ENV == 'development') ? true : false;
	
	}

	/**
	 * Função basica para a index do controller. 
	 */
	public function indexAction() {
		$pagina = intval($this->_getParam('pagina', 1));
		$adapter = new Zend_Paginator_Adapter_DbSelect($this->_mapper->getDbTable()->select());
		
		$paginator = new Zend_Paginator($adapter);
		// Seta a quantidade de registros por página
		$paginator->setItemCountPerPage(10);
		// numero de paginas que serão exibidas
		$paginator->setPageRange(5);
		// Seta a página atual
		$paginator->setCurrentPageNumber($pagina);
		// Passa o paginator para a view
		$this->view->entries = $paginator;
	
	}

	/**
	 * Função basica para a exclusao do controller. 
	 */
	public function excluirAction() {
		$ajax = $this->_request->getParam('ajax', false);
		$this->_helper->layout()->disableLayout();
		if ($this->getRequest()->getParam('id') == null) {
			$aParam = array('error' => 'Código do ' . strtolower($this->_labelController) . ' não informado.');
			$this->_helper->FlashMessenger($aParam);
			if (!$ajax)
				return $this->_helper->redirector('index');
		}
		
		try {
			$del = $this->_mapper->getDbTable()->delete('id' . $this->_mapper->_name . ' in(' . $this->getRequest()->getParam('id') . ') ');
			if (!$del)
				throw new Exception($this->_labelController . ' não encontrado.');
			$this->_helper->FlashMessenger($this->_labelController . ' excluído.');
			$this->_mapper->log('Delete',array('id'. $this->_mapper->_name=>$this->getRequest()->getParam('id')));
			if (!$ajax)
				return $this->_helper->redirector('index');
			else
				echo 'sucess';
		} catch (Exception $e) {
			$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
			if (!$ajax)
				return $this->_helper->redirector('index');
		}
		exit();
	}

	/**
	 * Função basica para a inclusao do controller. 
	 */
	public function incluirAction() {
		
		$this->view->headerText = 'Cadastro de ' . strtolower($this->_labelController);
		if ($this->getRequest()->isPost()) {
			$this->_session->formDados = $this->getRequest()->getPost();
			if ($this->_form->isValid($this->getRequest()->getPost())) {
				try {
					$id = $this->gravarAction();
					$this->_helper->FlashMessenger($this->_labelController . ' cadastrado.');
					return $this->_helper->redirector('alterar', $this->_request->getControllerName(), $this->_request->getModuleName(), array('id' => $id));
				} catch (Exception $e) {
					$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
				}
			} else {
				$this->_helper->FlashMessenger(array('warning' => 'Alguns erros foram encontrados no formulário.'));
			}
			if ($this->_debug)
				print_rpre($this->_form->getValues());
		}
		$this->view->form = $this->_form;
	}

	/**
	 * Função basica para a alteracao do controller. 
	 */
	public function alterarAction() {
		if ($this->getRequest()->getParam('id') == null) {
			$this->_helper->FlashMessenger(array('error' => 'Código do ' . $this->_labelController . ' não informado.'));
			return $this->_helper->redirector('index');
		}
		$this->view->headerText = 'Alterando ' . strtolower($this->_labelController);
		if ($this->getRequest()->isPost()) {
			if ($this->_form->isValid($this->getRequest()->getPost())) {
				try {
					$this->gravarAction();
					$this->_helper->FlashMessenger($this->_labelController . ' alterado.');
				} catch (Exception $e) {
					$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
				}
			} else {
				$this->_helper->FlashMessenger(array('warning' => 'Alguns erros foram encontrados no formulário.'));
			}
			if ($this->_debug)
				print_rpre($this->_form->getValues());
		} else {
			$this->_mapper->find($this->getRequest()->getParam('id'), $this->_model);
			$this->_form->populate($this->_model->toArray());
		}
		$this->view->form = $this->_form;
		$this->view->model = $this->_model;
	}

	/**
	 * Função basica para a gravação do controller. 
	 */
	public function gravarAction() {
		$this->_model->setOptions($this->getRequest()->getPost());
		return $this->_mapper->save($this->_model);
	}
}