<?php

class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		if ($request->getModuleName() == 'admin') {						
			if (!Zend_Auth::getInstance()->hasIdentity()) {				
				$request->setModuleName('login');
				$request->setControllerName('index');
				$request->setDispatched();
			}
			$controller = $request->getControllerName();
			$action = $request->getActionName();
			$applicationSession = new Zend_Session_Namespace('Autorizacao');
			
			/**
			 * @var Zend_Acl
			 */
			$acl = Zend_Registry::get('ACL');
			$module = Application_Model_ModuloMapper::instanciar();
			$permissaoMapper = Application_Model_PermissaoMapper::instanciar();
			$perfilMapper = Application_Model_PerfilMapper::instanciar();
			$aModulos = $module->fetchAll();
			if ($aModulos) {
				foreach ($aModulos as $modulo) {
					$acl->addResource(new Zend_Acl_Resource($modulo->getController()));
					$acl->allow('admin', $modulo->getController());
					$aPermissao = $permissaoMapper->fetchAll('idModulo=' . $modulo->getIdModulo());
					if ($aPermissao) {
						foreach ($aPermissao as $permissao) {
							$perfil = new Application_Model_Perfil();
							$perfilMapper->find($permissao->getIdPerfil(), $perfil);
							$acl->allow(strtolower($perfil->getNome()), $modulo->getController());
						}
					}
				}
			}
			
			try {
				$allowed = $acl->isAllowed($applicationSession->userRole, $controller);
				if (!$allowed) {
					$request->setControllerName('error');
					$request->setActionName('acl');
					$request->setDispatched();
				}
			} catch (Exception $e) {
				$request->setControllerName('error');
				$request->setActionName('acl');
				$request->setParam('erro', 'Página não encontrada. Verifique a opção escolhida.');
				$request->setDispatched();
			}
		}
	}
}