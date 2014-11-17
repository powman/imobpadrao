<?php

class Application_Model_ConfigMapper extends Application_Model_BaseMapper {

	public static function instanciar() {
		return new Application_Model_ConfigMapper('Config');
	}

	public function save(Application_Model_Config $model) {
		$data = $model->toArray();
		$operador = Zend_Auth::getInstance()->getIdentity();
		if (!$model->getIdFotoConf()) {
			$data['idUsuario_cadastro'] = $data['idUsuario_alteracao'] = $operador->idUsuario;
			$data['dhcadastro'] = $data['dhalteracao'] = date('Y-m-d h:i:s');
			return $this->getDbTable()->insert($data);
		} else {
			$data['idUsuario_alteracao'] = $operador->idUsuario;
			$data['dhalteracao'] = date('Y-m-d h:i:s');
			unset($data['idUsuario_cadastro']);
			unset($data['dhcadastro']);
			$this->getDbTable()->update($data, array('idFotoConf = ?' => $model->getIdFotoConf()));
			return $model->getIdFotoConf();
		}
	}
}

