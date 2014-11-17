<?php

class Application_Form_Arquivo extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('id');
		$this->addElement($id);
		
		$titulo = new Zend_Dojo_Form_Element_TextBox('titulo');
		$titulo->setLabel('Titulo :');
		$titulo->setRequired(true);
		$titulo->addValidator('NotEmpty', true, $aMsgError);
		$titulo->addValidator('StringLength', true, 
								array('max' => 200, 'messages' => array('stringLengthTooLong' => 'O titulo \'%value%\' não pode ser maior que 200')));
		$this->addElement($titulo);
		
		$imagem = new Zend_Form_Element_File('arquivo');
		$imagem->setLabel('Arquivo :');
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/upload.ini');
		$imagem->setDestination($config->uploaddir->pdf);
		$imagem->setAttribs($aAttribs);
		$imagem->addValidator('Count', true, 
								array(
											'max' => 1, 
											'min' => 1, 
											'messages' => array(
																		Zend_Validate_File_Count::TOO_FEW => 'Envie pelo menos 1 arquivo.', 
																		Zend_Validate_File_Count::TOO_MANY => 'Envie apenas um arquivo.')));
		$imagem->addValidator('Size', true, 10240000);
		
		$imagem->addValidator('Extension', true, 'pdf');
		
		$this->addElement($imagem);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>