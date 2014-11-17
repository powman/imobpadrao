<?php

class Application_Model_Banner extends Application_Model_Base {

	protected $idBanner;

	protected $nome;

	protected $status;

	protected $link;

	protected $imagem;

	protected $extensao;

	/**
	 * @return the $idBanner
	 */
	public function getIdBanner() {
		return $this->idBanner;
	}

	/**
	 * @return the $nome
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return the $link
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * @return the $imagem
	 */
	public function getImagem() {
		return $this->imagem;
	}
	
	/**
	 * @return the $imagemOld
	 */
	public function getImagemOld() {
		return $this->imagemOld;
	}

	/**
	 * @return the $extensao
	 */
	public function getExtensao() {
		return $this->extensao;
	}

	/**
	 * @param field_type $idBanner
	 */
	public function setIdBanner($idBanner) {
		$this->idBanner = $idBanner;
	}

	/**
	 * @param field_type $nome
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}

	/**
	 * @param field_type $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @param field_type $link
	 */
	public function setLink($link) {
		$this->link = $link;
	}

	/**
	 * @param field_type $imagem
	 */
	public function setImagem($imagem) {
		$this->imagem = $imagem;
	}

	/**
	 * @param field_type $extensao
	 */
	public function setExtensao($extensao) {
		$this->extensao = $extensao;
	}
}
?>