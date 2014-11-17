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
								'messages' => array('stringLengthTooLong' => 'O titulo \'%value%\' n�o pode ser maior que 200')));
		$this->addElement($titulo);
		
		$link = new Zend_Dojo_Form_Element_TextBox('link');
		$link->setLabel('Link : (Sem http://)');
		$link->setRequired(false);
		$aMensagem = array(
			Zend_Validate_Hostname::CANNOT_DECODE_PUNYCODE  => "'%value%' parece ser um DNS hostname mas a nota��o punycode dado n�o pode ser decodificado",
	        Zend_Validate_Hostname::INVALID                 => "Tipo inv�lido. esperado string",
	        Zend_Validate_Hostname::INVALID_DASH            => "'%value%' parece ser um DNS hostname mas cont�m um tra�o em uma posi��o inv�lida",
	        Zend_Validate_Hostname::INVALID_HOSTNAME        => "'%value%' endere�o inv�lido (n�o digite http://)",
	        Zend_Validate_Hostname::INVALID_HOSTNAME_SCHEMA => "'%value%' parece ser um DNS hostname mas n�o pode partida contra o esquema de hostname para TLD '%tld%'",
	        Zend_Validate_Hostname::INVALID_LOCAL_NAME      => "'%value%' n�o parece ser um nome de rede local v�lido",
	        Zend_Validate_Hostname::INVALID_URI             => "'%value%' n�o parece ser um URI v�lido hostname",
	        Zend_Validate_Hostname::IP_ADDRESS_NOT_ALLOWED  => "'%value%' parece ser um endere�o IP, mas endere�os IP n�o s�o permitidos",
	        Zend_Validate_Hostname::LOCAL_NAME_NOT_ALLOWED  => "'%value%' parece ser um nome de rede local, mas nomes de rede local n�o s�o permitidas",
	        Zend_Validate_Hostname::UNDECIPHERABLE_TLD      => "'%value%' parece ser um DNS hostname mas n�o pode extrair parte TLD",
	        Zend_Validate_Hostname::UNKNOWN_TLD             => "'%value%' parece ser um DNS hostname mas n�o consegue encontr� TLD contra a lista conhecida",
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