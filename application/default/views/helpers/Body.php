<?php

class Zend_View_Helper_Body extends Zend_View_Helper_Abstract {

	public function body() {
		$fc = Zend_Controller_Front::getInstance()->getRequest();
		$output = '';
		if ($fc->getControllerName() == 'imovel' && ($fc->getActionName() == 'destaque' || $fc->getActionName() == 'mapa') && $fc->getModuleName() == 'default') {
			$output = '<body onload="initialize();" onunload="GUnload();">';
		} else {
			$output = '<body>';
		
		}
		return $output;
	}
}