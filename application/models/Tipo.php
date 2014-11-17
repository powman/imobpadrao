<?php
class Application_Model_Tipo extends Application_Model_Base {
	
	protected $idtipo_imovel;
	protected $nmtipo_imovel;
	/**
	 * @return the $idtipo_imovel
	 */
	public function getIdtipo_imovel() {
		return $this->idtipo_imovel;
	}

	/**
	 * @return the $nmtipo_imovel
	 */
	public function getNmtipo_imovel() {
		return $this->nmtipo_imovel;
	}

	/**
	 * @param $idtipo_imovel the $idtipo_imovel to set
	 */
	public function setIdtipo_imovel($idtipo_imovel) {
		$this->idtipo_imovel = $idtipo_imovel;
	}

	/**
	 * @param $nmtipo_imovel the $nmtipo_imovel to set
	 */
	public function setNmtipo_imovel($nmtipo_imovel) {
		$this->nmtipo_imovel = $nmtipo_imovel;
	}

	
	
	
}	
?>