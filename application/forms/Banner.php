<?php

class Application_Form_Banner extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idBanner');
		$this->addElement($id);
		
		$imagem = new Zend_Form_Element_Hidden('imagemOld');
		$this->addElement($imagem);
		
		$extensao = new Zend_Form_Element_Hidden('extensao');
		$this->addElement($extensao);
		
		$titulo = new Zend_Dojo_Form_Element_TextBox('nome');
		$titulo->setLabel('Titulo :');
		$titulo->setRequired(true);
		
		$titulo->addValidator('NotEmpty', true, $aMsgError);
		$titulo->addValidator('StringLength', true, 
							array(
								'max' => 200, 
								'messages' => array('stringLengthTooLong' => 'O titulo \'%value%\' não pode ser maior que 200')));
		$this->addElement($titulo);
		
		$link = new Zend_Dojo_Form_Element_TextBox('link');
		$link->setLabel('Link : (Sem http://)');
		$link->setRequired(false);		
		$this->addElement($link);
		
		$imagem = new Zend_Form_Element_File('imagem');
		$imagem->setLabel('Banner : (Tamanho: 990x270)');
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/upload.ini');
		$imagem->setDestination($config->uploaddir->banner->dir);
		$imagem->setAttribs($aAttribs);
		$imagem->addValidator('Size', true, 2048000);
		$sMessage = 'Tamanho do banner invalido. Tamanho recomendado deve ser 990x270.';
		$imagem->addValidator('Extension', true, 'jpg,png,gif');
		$this->addElement($imagem);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('status');
		$item->setLabel('Ativo :');
		$this->addElement($item);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>