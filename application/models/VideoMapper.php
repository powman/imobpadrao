<?php

class Application_Model_VideoMapper extends Application_Model_BaseMapper {
	
	public static function instanciar() {
		return new Application_Model_VideoMapper ( 'Video' );
	}
	
	public function save(Application_Model_Base $model) {
		$data = $model->toArray ();
		$operador = Zend_Auth::getInstance ()->getIdentity ();
		$sGetFunc = 'getId' . $this->_name;
		
		unset ( $data ['idUsuario_cadastro'] );
		unset ( $data ['idUsuario_alteracao'] );
		unset ( $data ['dhalteracao'] );
		unset ( $data ['dhcadastro'] );
		
		if (! $model->$sGetFunc ()) {
			
			return $this->getDbTable ()->insert ( $data );
		} else {
			
			$this->getDbTable ()->update ( $data, array ('id' . $this->_name . ' = ?' => $model->$sGetFunc () ) );
			return $model->$sGetFunc ();
		}
	}

}

