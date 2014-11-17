<?php

class Application_Model_UsuarioMapper extends Application_Model_BaseMapper {

	public static function instanciar() {
		return new Application_Model_UsuarioMapper('Usuario');
	}

	public function findByUsuario($sUsuario, Application_Model_Usuario $model) {
		$result = $this->getDbTable()->fetchAll('login=' . $sUsuario);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current()->toArray();
		$model->setOptions($row);
	}
}

