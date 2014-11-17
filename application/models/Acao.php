<?php

class Application_Model_Acao extends Application_Model_Base {

	protected $idModulo_Action;

	protected $idModulo;

	protected $nmaction;

	/**
	 * @return the $idModulo_Action
	 */
	public function getIdModulo_Action() {
		return $this->idModulo_Action;
	}

	/**
	 * @return the $idModulo
	 */
	public function getIdModulo() {
		return $this->idModulo;
	}

	/**
	 * @return the $nmaction
	 */
	public function getNmaction() {
		return $this->nmaction;
	}

	/**
	 * @param $idModulo_Action the $idModulo_Action to set
	 */
	public function setIdModulo_Action($idModulo_Action) {
		$this->idModulo_Action = $idModulo_Action;
	}

	/**
	 * @param $idModulo the $idModulo to set
	 */
	public function setIdModulo($idModulo) {
		$this->idModulo = $idModulo;
	}

	/**
	 * @param $nmaction the $nmaction to set
	 */
	public function setNmaction($nmaction) {
		$this->nmaction = $nmaction;
	}
}
?>