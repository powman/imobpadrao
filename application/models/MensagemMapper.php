<?php

class Application_Model_MensagemMapper extends Application_Model_BaseMapper {

	public static function instanciar() {
		return new Application_Model_MensagemMapper('Mensagem');
	}

	public function save(Application_Model_Mensagem $model) {
		$data = $model->toArray();
		$operador = Zend_Auth::getInstance()->getIdentity();
		$sGetFunc = 'getId' . $this->_name;
		if (!$model->$sGetFunc()) {
			return $this->getDbTable()->insert($data);
		} else {
			unset($data['idUsuario_cadastro']);
			unset($data['dhcadastro']);
			$this->getDbTable()->update($data, array('id' . $this->_name . ' = ?' => $model->$sGetFunc()));
			return $model->$sGetFunc();
		}
	}

}

