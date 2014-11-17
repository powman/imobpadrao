<?php

class ErrorController extends Zend_Controller_Action {

	public function init() {
		
	}

	public function aclAction() {
		$this->view->errorMessage = ($this->_request->getParam('erro','Voc� n�o tem permiss�o para acessar este conte�do.'));
	}
	
	public function errorAction() {
		$errors = $this->_getParam('error_handler');
		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				
				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'P�gina n�o encontrada';
				break;
			default:
				// application error
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->message = 'Erro na aplica��o';
				break;
		}
		
		// Log exception, if logger available
		$log = '';
		if ($log = $this->getLog()) {
			$log->crit($this->view->message, $errors->exception);
		}
		
		// conditionally display exceptions
		if ($this->getInvokeArg('displayExceptions') == true) {
			$this->view->exception = $errors->exception;
		}
		
		$this->view->request = $errors->request;
	}

	public function getLog() {
		$bootstrap = $this->getInvokeArg('bootstrap');
		if (!$bootstrap->hasPluginResource('Log')) {
			return false;
		}
		$log = $bootstrap->getResource('Log');
		return $log;
	}

}

