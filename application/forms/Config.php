<?php
class Application_Form_Config extends Zend_Form {
	public function init() {
		$aAttribs = array('class'=>'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		$ValidarIdentificador = new Zend_Validate_StringLength();
		$ValidarIdentificador->setMin(4)->setMax(4)->setMessage("O identificador deve conter '%min%' dígitos");
		
		
		$this->setMethod('post');
		$idNoticiaCategoria = new Zend_Form_Element_Hidden('idFotoConf');
		$this->addElement($idNoticiaCategoria);
		
		$nomeCategoria = new Zend_Dojo_Form_Element_TextBox('identificador');
		$nomeCategoria->setLabel('Identificador :')->setRequired(true)->setAttribs($aAttribs)->addValidator('NotEmpty', true, $aMsgError)->addValidator($ValidarIdentificador);
		$this->addElement($nomeCategoria);
		
		$identificador = new Zend_Dojo_Form_Element_TextBox('tamanhos');
		$identificador->setLabel('Tamanhos :')->setRequired(true)->setAttribs($aAttribs)->addValidator('NotEmpty', true, $aMsgError);
		$identificador->setFilters(array('StringTrim'));
		$this->addElement($identificador);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('albumFixo');
		$item->setLabel('Album fixo:');
		$this->addElement($item);

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
		
	}
}
?>