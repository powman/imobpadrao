<?php

class Application_Model_Mensagem  {

	protected $idMensagem;

	protected $assunto;

	protected $nome;

	protected $email;

	protected $telefone;

	protected $status;

	protected $mensagem;

	/**
	 * @return the $idMensagem
	 */
	public function getIdMensagem() {
		return $this->idMensagem;
	}

	/**
	 * @return the $assunto
	 */
	public function getAssunto() {
		return $this->assunto;
	}

	/**
	 * @return the $nome
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $telefone
	 */
	public function getTelefone() {
		return $this->telefone;
	}

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return the $mensagem
	 */
	public function getMensagem() {
		return $this->mensagem;
	}

	/**
	 * @param field_type $idMensagem
	 */
	public function setIdMensagem($idMensagem) {
		$this->idMensagem = $idMensagem;
	}

	/**
	 * @param field_type $assunto
	 */
	public function setAssunto($assunto) {
		$this->assunto = $assunto;
	}

	/**
	 * @param field_type $nome
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}

	/**
	 * @param field_type $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @param field_type $telefone
	 */
	public function setTelefone($telefone) {
		$this->telefone = $telefone;
	}

	/**
	 * @param field_type $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @param field_type $mensagem
	 */
	public function setMensagem($mensagem) {
		$this->mensagem = $mensagem;
	}
	
	public function toArray() {
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

}