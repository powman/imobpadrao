<?php

class Application_Form_BuscaImovel extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');			
		
		$imovel = new Zend_Form_Element_Text('idimovel');
		$imovel->setLabel('Cód. Imóvel:');
		$this->addElement($imovel);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Pesquisar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	}
}
?>