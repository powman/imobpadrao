<?php

class Application_Form_Gridnoticia extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		
		$categoria = new Zend_Form_Element_Select('idNoticiaCategoria');
		$categoria->setLabel('Categoria :');
		$categoria->setRequired(true);
		$categoria->setAttribs($aAttribs);
		$categoria->addValidator('NotEmpty', true, $aMsgError);
		$cat = Application_Model_CategoriaMapper::instanciar();
		foreach ($cat->fetchAll() as $row) {
			$categoria->addMultiOption($row->getIdNoticiaCategoria(), $row->getNomeCategoria());
		}
		$this->addElement($categoria);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Pesquisar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	}
}
?>