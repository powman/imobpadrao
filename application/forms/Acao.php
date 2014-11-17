<?php
class Application_Form_Acao extends Zend_Form {
	public function init() {
		
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		$ValidarIdentificador = new Zend_Validate_StringLength();
		$ValidarIdentificador->setMin(4)->setMax(4)->setMessage("O identificador deve conter '%min%' dнgitos");
				
		$this->setMethod('post');
		$idModulo_Action = new Zend_Form_Element_Hidden('idModulo_Action');
		$this->addElement($idModulo_Action);
		
		$idModulo = new Zend_Form_Element_Hidden('idModulo');
		$this->addElement($idModulo);
		
		$nome = new Zend_Dojo_Form_Element_TextBox('nmaction');
		$nome->setLabel('Nome da aзгo :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nome);	
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
		
	}
}
?>