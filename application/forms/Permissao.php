<?php

class Application_Form_Permissao extends Zend_Form {

	public function init() {
		$this->setMethod('post');
		$this->setAction('modulo/permissao');
		$categoria = new Zend_Form_Element_MultiCheckbox('idPerfil');
		$categoria->setLabel('Categoria :');
		$categoria->setRequired(true);
		$cat = Application_Model_PerfilMapper::instanciar();
		foreach ($cat->fetchAll('idPerfil != 1') as $row) {
			$categoria->addMultiOption($row->getIdPerfil(), $row->getNome());
		}
		$this->addElement($categoria);
		$elemento = new Zend_Form_Element_Hidden('id');
		$this->addElement($elemento);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Alterar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>