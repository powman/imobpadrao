<?php

class Application_Model_Usuario extends Application_Model_Base {

	/**
	 * Código do usuário
	 * @var integer
	 */
	protected $idUsuario;

	/**
	 * Nome do usuário
	 * @var string
	 */
	protected $nome;

	/**
	 * Senha criptografada do usuário.
	 * @var string
	 */
	protected $senha;

	/**
	 * Login do usuario.
	 * @var string
	 */
	protected $login;

	/**
	 * E-mail do usuário
	 * @var string
	 */
	protected $email;

	/**
	 * Código do perfil de acesso do usuario. Referenciado na tabela "perfil"
	 * @var integer
	 */
	protected $idPerfil;

	/**
	 * @return the $id
	 */
	public function getIdUsuario() {
		return $this->idUsuario;
	}

	/**
	 * @return the $nome
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * @return the $senha
	 */
	public function getSenha() {
		return $this->senha;
	}

	/**
	 * @return the $login
	 */
	public function getLogin() {
		return $this->login;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $idPerfil
	 */
	public function getIdPerfil() {
		return $this->idPerfil;
	}

	/**
	 * @param integer $id
	 */
	public function setIdUsuario($id) {
		$this->idUsuario = $id;
	}

	/**
	 * @param string $nome
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}

	/**
	 * @param string $senha
	 */
	public function setSenha($senha) {
		$this->senha = md5($senha);
	}

	/**
	 * @param string $login
	 */
	public function setLogin($login) {
		$this->login = $login;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @param integer $idPerfil
	 */
	public function setIdPerfil($idPerfil) {
		$this->idPerfil = $idPerfil;
	}

}