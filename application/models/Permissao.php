<?php

class Application_Model_Permissao extends Application_Model_Base {

	protected $idPermissao;

	protected $idModulo;

	protected $idPerfil;

	/*protected $visualizar;

	protected $incluir;

	protected $alterar;

	protected $exlcuir;*/
	
	/**
	 * @return the $idPermissao
	 */
	public function getIdPermissao() {
		return $this->idPermissao;
	}

	/**
	 * @return the $idModulo
	 */
	public function getIdModulo() {
		return $this->idModulo;
	}

	/**
	 * @return the $idPerfil
	 */
	public function getIdPerfil() {
		return $this->idPerfil;
	}

	/**
	 * @param field_type $idPermissao
	 */
	public function setIdPermissao($idPermissao) {
		$this->idPermissao = $idPermissao;
	}

	/**
	 * @param field_type $idModulo
	 */
	public function setIdModulo($idModulo) {
		$this->idModulo = $idModulo;
	}

	/**
	 * @param field_type $idPerfil
	 */
	public function setIdPerfil($idPerfil) {
		$this->idPerfil = $idPerfil;
	}

}