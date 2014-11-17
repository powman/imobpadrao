<?php

class Application_Form_Noticiacat extends Zend_Form {

	public function init() {
		
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		$ValidarIdentificador = new Zend_Validate_StringLength();
		$ValidarIdentificador->setMin(4)->setMax(4)->setMessage("O identificador deve conter '%min%' dígitos");
		
		$this->setMethod('post');
		$idNoticiaCategoria = new Zend_Form_Element_Hidden('idNoticiaCategoria');
		$this->addElement($idNoticiaCategoria);
		
		$nomeCategoria = new Zend_Dojo_Form_Element_TextBox('nomeCategoria');
		$nomeCategoria->setLabel('Nome :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nomeCategoria);
		
		$identificador = new Zend_Dojo_Form_Element_TextBox('identificador');
		$identificador->setLabel('Identificador :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError)->addValidator(
																																$ValidarIdentificador);
		$identificador->setFilters(array('StringTrim'));
		$this->addElement($identificador);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>