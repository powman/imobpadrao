<?php

class Application_Form_Modulo extends Zend_Form {

	public function init() {
		$this->setAttribs(array('accept-charset'=>'ISO-8859-1'));
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preenche corretamente o campo."));

		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idModulo');
		$this->addElement($id);
		
		$item = new Zend_Dojo_Form_Element_TextBox('nmmodulo');
		$item->setLabel('Nome :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_TextBox('controller');
		$item->setLabel('Controller :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_TextBox('descricao');
		$item->setLabel('Descricao :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_TextBox('icon_class');
		$item->setLabel('Icone :')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('ativo');
		$item->setLabel('Ativo :');

		$this->addElement($item);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
		
		
		
	
	}
}