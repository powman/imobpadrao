<?php

class Application_Model_Categoria extends Application_Model_Base {

	protected $idCategoria;

	protected $nome;
	
	protected $idTipoImovel;
	
	protected $categoria;

	protected $status;
	
	/**
	 * @return the $idParceiro
	 */
	public function getIdCategoria() {
		return $this->idCategoria;
	}

	/**
	 * @return the $nome
	 */
	public function getNome() {
		return $this->nome;
	}
	
	/**
	 * @return the $idTipoImovel
	 */
	public function getIdTipoImovel() {
		return $this->idTipoImovel;
	}
	

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 * @return the $ordem
	 */
	public function getOrdem() {
		return $this->ordem;
	}
	

	/**
	 * @return the $categoria
	 */
	public function getCategoria() {
		return $this->categoria;
	}

	

	/**
	 * @param field_type $idCategoria
	 */
	public function setIdCategoria($idCategoria) {
		$this->idCategoria = $idCategoria;
	}

	/**
	 * @param field_type $nome
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}

	/**
	 * @param field_type $idTipoImovel
	 */
	public function setIdTipoImovel($idTipoImovel) {
		$this->idTipoImovel = $idTipoImovel;
	}

	/**
	 * @param field_type $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @param field_type $ordem
	 */
	public function setOrdem($ordem) {
		$this->ordem = $ordem;
	}

	/**
	 * @param field_type $categoria
	 */
	public function setCategoria($categoria) {
		$this->categoria = $categoria;
	}


	

}
?>