<?php
class Application_Form_Login extends Zend_Form {
	public function init() {
		$this->setMethod ( 'post' );
		$this->addElement ( 'text', 'Usuario', array ('label' => 'Digite o usuario:', 'required' => true ) );
		$this->addElement ( 'password', 'senha', array ('label' => 'Digite a senha:', 'required' => true ) );
		$this->addElement ( 'submit', 'submit', array ('ignore' => true, 'label' => 'Cadastrar', 'class' => 'button' ) );
	}
}