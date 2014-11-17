<?php

class Application_Form_Pagina extends Zend_Form {

	public function init() {
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idPagina');
		$this->addElement($id);
		
		$nome = new Zend_Dojo_Form_Element_TextBox('nome_pagina');
		$nome->setLabel('Nome da página:')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nome);
		
		$html = new Zend_Form_Element_FCKEditor('html');
		$html->setAttribs(array('ToolbarSet' => 'Default', 'Width' => '100%', 'Height' => '500'));
		$html->setLabel('Conteúdo:')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($html);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('ativa');
		$item->setLabel('Ativo :');
		$this->addElement($item);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>