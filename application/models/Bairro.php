<?php 
class Application_Model_Bairro extends Application_Model_Base {

	protected $idsetor;

	protected $nmsetor;

	protected $idcidade;
	
	
	/**
	 * @return the $idsetor
	 */
	public function getIdsetor() {
		return $this->idsetor;
	}

	/**
	 * @return the $nmsetor
	 */
	public function getNmsetor() {
		return $this->nmsetor;
	}

	/**
	 * @return the $idcidade
	 */
	public function getIdcidade() {
		return $this->idcidade;
	}

	/**
	 * @param $idsetor the $idsetor to set
	 */
	public function setIdsetor($idsetor) {
		$this->idsetor = $idsetor;
	}

	/**
	 * @param $nmsetor the $nmsetor to set
	 */
	public function setNmsetor($nmsetor) {
		$this->nmsetor = $nmsetor;
	}

	/**
	 * @param $idcidade the $idcidade to set
	 */
	public function setIdcidade($idcidade) {
		$this->idcidade = $idcidade;
	}

	
	
}
