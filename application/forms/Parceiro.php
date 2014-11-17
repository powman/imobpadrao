<?php

class Application_Form_Parceiro extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idParceiro');
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
								'messages' => array('stringLengthTooLong' => 'O titulo \'%value%\' nгo pode ser maior que 200')));
		$this->addElement($titulo);
		
		$link = new Zend_Dojo_Form_Element_TextBox('link');
		$link->setLabel('Link : (Sem http://)');
		$link->setRequired(false);
		$aMensagem = array(
			Zend_Validate_Hostname::CANNOT_DECODE_PUNYCODE  => "'%value%' parece ser um DNS hostname mas a notaзгo punycode dado nгo pode ser decodificado",
	        Zend_Validate_Hostname::INVALID                 => "Tipo invбlido. esperado string",
	        Zend_Validate_Hostname::INVALID_DASH            => "'%value%' parece ser um DNS hostname mas contйm um traзo em uma posiзгo invбlida",
	        Zend_Validate_Hostname::INVALID_HOSTNAME        => "'%value%' endereзo invбlido (nгo digite http://)",
	        Zend_Validate_Hostname::INVALID_HOSTNAME_SCHEMA => "'%value%' parece ser um DNS hostname mas nгo pode partida contra o esquema de hostname para TLD '%tld%'",
	        Zend_Validate_Hostname::INVALID_LOCAL_NAME      => "'%value%' nгo parece ser um nome de rede local vбlido",
	        Zend_Validate_Hostname::INVALID_URI             => "'%value%' nгo parece ser um URI vбlido hostname",
	        Zend_Validate_Hostname::IP_ADDRESS_NOT_ALLOWED  => "'%value%' parece ser um endereзo IP, mas endereзos IP nгo sгo permitidos",
	        Zend_Validate_Hostname::LOCAL_NAME_NOT_ALLOWED  => "'%value%' parece ser um nome de rede local, mas nomes de rede local nгo sгo permitidas",
	        Zend_Validate_Hostname::UNDECIPHERABLE_TLD      => "'%value%' parece ser um DNS hostname mas nгo pode extrair parte TLD",
	        Zend_Validate_Hostname::UNKNOWN_TLD             => "'%value%' parece ser um DNS hostname mas nгo consegue encontrб TLD contra a lista conhecida",
		);
		$link->addValidator('Hostname', true, array('messages' => $aMensagem)); 
		$this->addElement($link);
		
		$imagem = new Zend_Form_Element_File('imagem');
		$imagem->setLabel('Logo :');
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/upload.ini');
		$imagem->setDestination($config->uploaddir->parceiro->dir);
		$imagem->setAttribs($aAttribs);
		$imagem->addValidator('Size', true, 1024000);
		$sMessage = 'Tamanho da logo invalido. Tamanho recomendado deve ser 276x210.';
		$imagem->addValidator('Extension', true, 'jpg,png,gif');
		$imagem->addValidator('ImageSize', true, 
							array(
								'maxwidth' => $config->uploaddir->parceiro->maxwidth, 
								'minwidth' => $config->uploaddir->parceiro->minwidth, 
								'maxheight' => $config->uploaddir->parceiro->maxheight, 
								'minheight' => $config->uploaddir->parceiro->minheight, 
								'messages' => array(
													Zend_Validate_File_ImageSize::WIDTH_TOO_SMALL => $sMessage, 
													Zend_Validate_File_ImageSize::WIDTH_TOO_BIG => $sMessage, 
													Zend_Validate_File_ImageSize::HEIGHT_TOO_BIG => $sMessage, 
													Zend_Validate_File_ImageSize::HEIGHT_TOO_SMALL => $sMessage)));
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