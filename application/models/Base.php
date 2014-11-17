<?php

/**
 * Classe base para crianção dos models.
 * @author Richard Ramalho
 * @since 28/09/2011
 */
abstract class Application_Model_Base {

	/**
	 * Código do usuário que cadastrou o registro.
	 * @var integer
	 */
	protected $idUsuario_cadastro;
	
	/**
	 * Data que o usuário cadastrou o registro.
	 * @var integer
	 */
	protected $dhcadastro;

	/**
	 * Código do usuário que alterou o registro.
	 * @var integer
	 */
	protected $idUsuario_alteracao;

	/**
	 * Data que o usuário alterou o registro.
	 * @var integer
	 */
	protected $dhalteracao;

	/**
	 * Lista os atributos da classe
	 * @return array 
	 */
	final public function toArray() {
		$aAttrs = get_class_vars(get_class($this));
		$aReturn = array();
		if (!$aAttrs)
			throw new Exception('Classe seleciona não possue atributos', '500');
		foreach ($aAttrs as $key => $attr) {
			$method = 'get' . ucfirst($key);
			$aReturn[$key] = $this->$method();
		}
		return $aReturn;
	}

	final public function __construct(array $options = null) {
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}

	final public function setOptions(array $options) {
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}

	/**
	 * @return the $idUsuario_cadastro
	 */
	public function getIdUsuario_cadastro() {
		return $this->idUsuario_cadastro;
	}

	/**
	 * @return the $dhcadastro
	 */
	public function getDhcadastro() {
		return $this->dhcadastro;
	}

	/**
	 * @return the $idUsuario_alteracao
	 */
	public function getIdUsuario_alteracao() {
		return $this->idUsuario_alteracao;
	}

	/**
	 * @return the $dhalteracao
	 */
	public function getDhalteracao() {
		return $this->dhalteracao;
	}

	/**
	 * @param integer $idUsuario_cadastro
	 */
	public function setIdUsuario_cadastro($idUsuario_cadastro) {
		$this->idUsuario_cadastro = $idUsuario_cadastro;
	}

	/**
	 * @param integer $dhcadastro
	 */
	public function setDhcadastro($dhcadastro) {
		$this->dhcadastro = $dhcadastro;
	}

	/**
	 * @param integer $idUsuario_alteracao
	 */
	public function setIdUsuario_alteracao($idUsuario_alteracao) {
		$this->idUsuario_alteracao = $idUsuario_alteracao;
	}

	/**
	 * @param integer $dhalteracao
	 */
	public function setDhalteracao($dhalteracao) {
		$this->dhalteracao = $dhalteracao;
	}

}