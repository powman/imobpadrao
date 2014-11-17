<?php

class Admin_ModuloController extends Zend_BaseController {

	public function permissaoAction() {
		$form = new Application_Form_Permissao();
		$request = $this->getRequest();
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		if (!$request->getParam('id'))
			throw new Exception('Modulo não informado.');
		$idModulo = $request->getParam('id');
		$modulo = new Application_Model_Modulo();
		$this->_mapper->find($idModulo, $modulo);
		$this->_helper->layout()->disableLayout();
		$mapper = Application_Model_PermissaoMapper::instanciar();
		$permissao = new Application_Model_Permissao();
		if ($request->isPost()) {
			$mapper->getDbTable()->delete('idModulo = ' . $idModulo);
			$permissao->setIdModulo($idModulo);
			$aPerfil = $request->getParam('idPerfil');
			foreach ($aPerfil as $perfil) {
				$permissao->setIdPerfil($perfil);
				$mapper->save($permissao);
			}
			$this->_helper->FlashMessenger('Permissões do modulo ' . $modulo->getNmmodulo() . ' alteradas.!');
			return $this->_helper->redirector('index');
		}
		$aPermissoes = $mapper->fetchAll('idModulo =' . $idModulo);
		$aValores = array();
		foreach ($aPermissoes as $perm) {
			$aValores[] = $perm->getIdPerfil();
		}
		$form->populate(array('idPerfil' => $aValores, 'id' => $idModulo));
		$this->view->form = $form;
		$this->view->modulo = $modulo;
	}

}