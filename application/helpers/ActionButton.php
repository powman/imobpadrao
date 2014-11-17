<?php

class Zend_View_Helper_ActionButton extends Zend_View_Helper_Abstract {

	public function actionButton($controller = 'index', $action = 'index', $modulo = 'admin', $label = 'Voltar', $param = null) {
		$aParams = array('controller' => $controller, 'action' => $action, 'module' => $modulo);
		if ($param)
			foreach ($param as $k => $p)
				$aParams[$k] = $p;
		$sUrl = $this->view->url($aParams, 'default', true);
		$output = '<input type="button" id="' . strtolower($label) . '" onclick="location.href=\'';
		$output .= $sUrl . '\'"	class="button" value="' . $label . '"></input>';
		
		$applicationSession = new Zend_Session_Namespace('Autorizacao');
		$acl = Zend_Registry::get('ACL');
		$allowed = $acl->isAllowed($applicationSession->userRole, $controller, $action);
		return ($allowed) ? $output : '';
	}

}