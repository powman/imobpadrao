<?php
class Application_Form_Seo extends Zend_Form {
	public function init() {
		$aAttribs = array('class'=>'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$idSeo = new Zend_Form_Element_Hidden('idSeo');
		$this->addElement($idSeo);
		
		$nmpagina = new Zend_Dojo_Form_Element_TextBox('nmpagina');
		$nmpagina->setLabel('Página :')->setRequired(true)->setAttribs($aAttribs)->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nmpagina);
		
		$metaTitle = new Zend_Form_Element_Textarea('metaTitle');
		$metaTitle->setLabel('Title(content) :')->setAttribs($aAttribs)->addValidator('NotEmpty', true, $aMsgError)->setOptions(array('rows'=>'10', 'colums'=>'30'));
		$this->addElement($metaTitle);
		
		$metaDescription = new Zend_Form_Element_Textarea('metaDescription');
		$metaDescription->setLabel('Description(content) :')->setAttribs($aAttribs)->addValidator('NotEmpty', true, $aMsgError)->setOptions(array('rows'=>'10', 'colums'=>'30'));
		$this->addElement($metaDescription);
		
		$metaKeywords = new Zend_Form_Element_Textarea('metaKeywords');
		$metaKeywords->setLabel('Keywords(content) :')->setAttribs($aAttribs)->addValidator('NotEmpty', true, $aMsgError)->setOptions(array('rows'=>'10', 'colums'=>'30'));
		$this->addElement($metaKeywords);
		

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
		
	}
}
?>