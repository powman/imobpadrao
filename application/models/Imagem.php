<?php

class Application_Model_Imagem extends Application_Model_Base {

	private $idfoto;

	private $nmfoto;

	private $idimovel;

	private $descricao;
	
	/**
	 * @return the $idfoto
	 */
	public function getIdfoto() {
		return $this->idfoto;
	}

	/**
	 * @return the $nmfoto
	 */
	public function getNmfoto() {
		return $this->nmfoto;
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
	 * @param $idfoto the $idfoto to set
	 */
	public function setIdfoto($idfoto) {
		$this->idfoto = $idfoto;
	}

	/**
	 * @param $nmfoto the $nmfoto to set
	 */
	public function setNmfoto($nmfoto) {
		$this->nmfoto = $nmfoto;
	}

	/**
	 * @param $idimovel the $idimovel to set
	 */
	public function setIdimovel($idimovel) {
		$this->idimovel = $idimovel;
	}

	/**
	 * @param $descricao the $descricao to set
	 */
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}


	
}