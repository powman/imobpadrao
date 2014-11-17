<?php

class Application_Model_Idioma extends Application_Model_Base {

	protected $ididioma;
	
	protected $idimovel;

	protected $descricao;

	protected $endereco;

	protected $complemento;

	protected $idioma;
	
	/**
	 * @return the $ididioma
	 */
	public function getIdidioma() {
		return $this->ididioma;
	}

	/**
	 * @return the $idimovel
	 */
	public function getIdimovel() {
		return $this->idimovel;
	}

	/**
	 * @return the $descricao
	 */
	public function getDescricao() {
		return $this->descricao;
	}

	/**
	 * @return the $endereco
	 */
	public function getEndereco() {
		return $this->endereco;
	}

	/**
	 * @return the $complemento
	 */
	public function getComplemento() {
		return $this->complemento;
	}

	/**
	 * @return the $idioma
	 */
	public function getIdioma() {
		return $this->idioma;
	}

	/**
	 * @param field_type $ididioma
	 */
	public function setIdidioma($ididioma) {
		$this->ididioma = $ididioma;
	}

	/**
	 * @param field_type $idimovel
	 */
	public function setIdimovel($idimovel) {
		$this->idimovel = $idimovel;
	}

	/**
	 * @param field_type $descricao
	 */
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}

	/**
	 * @param field_type $endereco
	 */
	public function setEndereco($endereco) {
		$this->endereco = $endereco;
	}

	/**
	 * @param field_type $complemento
	 */
	public function setComplemento($complemento) {
		$this->complemento = $complemento;
	}

	/**
	 * @param field_type $idioma
	 */
	public function setIdioma($idioma) {
		$this->idioma = $idioma;
	}

	
			
}
?>