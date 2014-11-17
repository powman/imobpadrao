<?php

class Application_Form_Album extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$this->addElement(new Zend_Form_Element_Hidden('idFotoAlbum'));
		$this->addElement(new Zend_Form_Element_Hidden('idFotoConf'));
		$this->addElement(new Zend_Form_Element_Hidden('idPluginRef'));
		
		$titulo = new Zend_Dojo_Form_Element_TextBox('nomeAlbum');
		$titulo->setLabel('Nome :');
		$titulo->setRequired(true);
		
		$titulo->addValidator('NotEmpty', true, $aMsgError);
		$titulo->addValidator('StringLength', true, 
							array(
								'max' => 200, 
								'messages' => array('stringLengthTooLong' => 'O titulo \'%value%\' nуo pode ser maior que 200')));
		$this->addElement($titulo);
		
		$descricao = new Zend_Dojo_Form_Element_Editor('descricaoAlbum');
		$descricao->setLabel('Descriчуo :');		
		$this->addElement($descricao);
		
		$modelConfig = Application_Model_ConfigMapper::instanciar();
		$aConfig = $modelConfig->fetchAll('albumFixo = false');
		$configElement = new Zend_Dojo_Form_Element_ComboBox('idFotoConf');
		$configElement->setLabel('Configuraчуo :')->setRequired(true);
		$configElement->addValidator('NotEmpty', true, $aMsgError);
		foreach ($aConfig as $config) {
			$configElement->addMultiOption($config->getIdFotoConf(), $config->getIdentificador());
		}
		$this->addElement($configElement);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>