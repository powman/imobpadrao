<?php

class Application_Form_Idioma extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		
		$idImovel = new Zend_Form_Element_Hidden('idimovel');
		$this->addElement($idImovel);
		
		$idIdioma = new Zend_Form_Element_Hidden('ididioma');
		$this->addElement($idIdioma);
		
		$descricao = new Zend_Dojo_Form_Element_Editor('descricao');
		$descricao->setLabel('Descrição :');
		$descricao->setAttribs(array('ToolbarSet'=>'Default','Width'=>'100%','Height'=>'100'));
		$descricao->setRequired(false);
		$descricao->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($descricao);
		
		$endereco = new Zend_Dojo_Form_Element_Editor('endereco');
		$endereco->setLabel('Endereço :');
		$endereco->setAttribs(array('ToolbarSet'=>'Default','Width'=>'100%','Height'=>'100'));
		$endereco->setRequired(false);
		$endereco->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($endereco);
		
		$complemento = new Zend_Dojo_Form_Element_Editor('complemento');
		$complemento->setLabel('Complemento :');
		$complemento->setAttribs(array('ToolbarSet'=>'Default','Width'=>'100%','Height'=>'100'));
		$complemento->setRequired(false);
		$complemento->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($complemento);
				
		$idIdioma = new Zend_Form_Element_Hidden('idioma');
		$this->addElement($idIdioma);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>