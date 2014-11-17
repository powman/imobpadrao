<?php

class Application_Model_Perfil extends Application_Model_Base {

	private $idPerfil;

	private $nome;
	/**
	 * @return the $idPerfil
	 */
	public function getIdPerfil() {
		return $this->idPerfil;
	}

	/**
	 * @return the $nome
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * @param field_type $idPerfil
	 */
	public function setIdPerfil($idPerfil) {
		$this->idPerfil = $idPerfil;
	}

	/**
	 * @param field_type $nome
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}



}
?>