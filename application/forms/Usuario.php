<?php

class Application_Form_Usuario extends Zend_Dojo_Form {

	public function init() {
		$this->setAttribs(array('accept-charset' => 'ISO-8859-1'));
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preenche corretamente o campo."));
		$ValidarSenha = new Zend_Validate_StringLength();
		$ValidarSenha->setMin(6)->setMessage("A senha deve conter mais de '%min%' digitos");
		$ValidarEmail = new Zend_Validate_EmailAddress();
		$ValidarEmail->setMessage('\'%value%\' não é um e-mail valido. Ex: usuario@dominio.com', 
								Zend_Validate_EmailAddress::INVALID_FORMAT);
		Zend_Dojo::enableForm($this);
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idUsuario');
		$this->addElement($id);
		
		$nome = new Zend_Dojo_Form_Element_ValidationTextBox('nome');
		$nome->setLabel('Nome :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nome);
		
		$email = new Zend_Dojo_Form_Element_ValidationTextBox('email');
		$email->setLabel('E-mail :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError)->addValidator($ValidarEmail);
		$email->setFilters(array('StringTrim'));
		$this->addElement($email);
		
		$login = new Zend_Dojo_Form_Element_ValidationTextBox('login');
		$login->setLabel('Login :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($login);
		
		$perfil = new Zend_Form_Element_Select('idPerfil');
		$perfil->setLabel('Perfil :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$perfilModel = Application_Model_PerfilMapper::instanciar();
		$aPerfil = $perfilModel->fetchAll('idPerfil > ' . Zend_Auth::getInstance()->getIdentity()->idPerfil);
		$options = array();
		foreach ($aPerfil as $perfilUser)
			$perfil->addMultiOption($perfilUser->getIdPerfil(), $perfilUser->getNome());
		$this->addElement($perfil);
		
		$senha = new Zend_Dojo_Form_Element_PasswordTextBox('senha');
		$senha->setRegExp('^[a-z0-9]{6,}$');
		$senha->setLabel('Senha :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError)->addValidator($ValidarSenha);
		$this->addElement($senha);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}