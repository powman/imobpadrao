<?php

class Application_Form_Teste extends Zend_Dojo_Form {

	public function init() {
		$this->setMethod('POST');
		$this->setAttrib('onSubmit', 'teste()');
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idTeste');
		$this->addElement($id);
		
		$item = new Zend_Dojo_Form_Element_Textarea('nmteste');
		$item->setLabel('Nome teste:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_Textarea('campo');
		$item->setLabel('campo:');
		$this->addElement($item);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}