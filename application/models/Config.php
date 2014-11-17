<?php

class Application_Model_Config extends Application_Model_Base {

	protected $idFotoConf;

	protected $albumFixo;

	protected $tamanhos;

	protected $identificador;

	/**
	 * @return the $idFotoConf
	 */
	public function getIdFotoConf() {
		return $this->idFotoConf;
	}

	/**
	 * @return the $albumFixo
	 */
	public function getAlbumFixo() {
		return $this->albumFixo;
	}

	/**
	 * @return the $tamanhos
	 */
	public function getTamanhos() {
		return $this->tamanhos;
	}

	/**
	 * @return the $identificador
	 */
	public function getIdentificador() {
		return $this->identificador;
	}

	/**
	 * @param field_type $idFotoConf
	 */
	public function setIdFotoConf($idFotoConf) {
		$this->idFotoConf = $idFotoConf;
	}

	/**
	 * @param field_type $albumFixo
	 */
	public function setAlbumFixo($albumFixo) {
		$this->albumFixo = $albumFixo;
	}

	/**
	 * @param field_type $tamanhos
	 */
	public function setTamanhos($tamanhos) {
		$this->tamanhos = $tamanhos;
	}

	/**
	 * @param field_type $identificador
	 */
	public function setIdentificador($identificador) {
		$this->identificador = $identificador;
	}

}
?>