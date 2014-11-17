<?php
class Application_Form_Vendedor extends Zend_Form {
	public function init() {
		
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		$ValidarIdentificador = new Zend_Validate_StringLength();
		$ValidarIdentificador->setMin(4)->setMax(4)->setMessage("O identificador deve conter '%min%' dígitos");
		
		
		$this->setMethod('post');
		$idvendedor = new Zend_Form_Element_Hidden('idvendedor');
		$this->addElement($idvendedor);
		
		$nomeCategoria = new Zend_Dojo_Form_Element_TextBox('nome');
		$nomeCategoria->setLabel('Nome :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nomeCategoria);

		$nomeCategoria = new Zend_Dojo_Form_Element_TextBox('telefone');
		$nomeCategoria->setLabel('telefone :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nomeCategoria);
		
		$nomeCategoria = new Zend_Dojo_Form_Element_TextBox('email');
		$nomeCategoria->setLabel('Email :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nomeCategoria);
		
		$nomeCategoria = new Zend_Dojo_Form_Element_TextBox('login');
		$nomeCategoria->setLabel('Login :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nomeCategoria);
		
		$nomeCategoria = new Zend_Dojo_Form_Element_PasswordTextBox('senha');
		$nomeCategoria->setLabel('Senha :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nomeCategoria);

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
		
	}
}
?>