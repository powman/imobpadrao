<?php

class Application_Model_Modulo extends Application_Model_Base {

	protected $idModulo;

	protected $nmmodulo;

	protected $controller;

	protected $descricao;

	protected $ativo;

	protected $icon_class;

	/**
	 * @return the $idModulo
	 */
	public function getIdModulo() {
		return $this->idModulo;
	}

	/**
	 * @return the $nmmodulo
	 */
	public function getNmmodulo() {
		return $this->nmmodulo;
	}

	/**
	 * @return the $descricao
	 */
	public function getDescricao() {
		return $this->descricao;
	}

	/**
	 * @return the $ativo
	 */
	public function getAtivo() {
		return $this->ativo;
	}

	/**
	 * @return the $icon_class
	 */
	public function getIcon_class() {
		return $this->icon_class;
	}

	/**
	 * @param field_type $idModulo
	 */
	public function setIdModulo($idModulo) {
		$this->idModulo = $idModulo;
	}

	/**
	 * @param field_type $nmmodulo
	 */
	public function setNmmodulo($nmmodulo) {
		$this->nmmodulo = $nmmodulo;
	}

	/**
	 * @param field_type $descricao
	 */
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}

	/**
	 * @param field_type $ativo
	 */
	public function setAtivo($ativo) {
		$this->ativo = $ativo;
	}

	/**
	 * @param field_type $icon_class
	 */
	public function setIcon_class($icon_class) {
		$this->icon_class = $icon_class;
	}

	/**
	 * @return the $controller
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 * @param field_type $controller
	 */
	public function setController($controller) {
		$this->controller = $controller;
	}

}