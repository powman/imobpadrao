<?php 
class Application_Model_Cidade extends Application_Model_Base {

	protected $idcidade;

	protected $nmcidade;

	/**
	 * @return the $idcidade
	 */
	public function getIdcidade() {
		return $this->idcidade;
	}

	/**
	 * @return the $nmcidade
	 */
	public function getNmcidade() {
		return $this->nmcidade;
	}

	/**
	 * @param $idcidade the $idcidade to set
	 */
	public function setIdcidade($idcidade) {
		$this->idcidade = $idcidade;
	}

	/**
	 * @param $nmcidade the $nmcidade to set
	 */
	public function setNmcidade($nmcidade) {
		$this->nmcidade = $nmcidade;
	}

	
	
}
?>