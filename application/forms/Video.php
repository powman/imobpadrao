<?php

class Application_Form_Video extends Zend_Form {

	public function init() {
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idVideo');
		$this->addElement($id);
		
		$titulo = new Zend_Dojo_Form_Element_TextBox('titulo');
		$titulo->setLabel('Título:')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($titulo);
				
		$imovel = new Zend_Form_Element_Hidden('idimovel');		
		$this->addElement($imovel);			
		
		$video = new Zend_Form_Element_Textarea('video');
		$video->setAttribs(array('cols'=>'80', 'rows'=>'5'));		
		$video->setLabel('Código do Youtube:')->setRequired(true)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($video);
		
		$ativo = new Zend_Dojo_Form_Element_CheckBox('ativo');
		$ativo->setLabel('Ativo :');
		$this->addElement($ativo);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>