<?php

class Admin_SeoController extends Zend_BaseController {

	/**
	 * Fun��o basica para a exclusao do controller. 
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
}