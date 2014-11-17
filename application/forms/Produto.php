<?php

class Application_Form_Produto extends Zend_Dojo_Form {

	public function init() {
		$this->setMethod('POST');
		$this->setAttrib('onSubmit', 'teste()');
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idProduto');
		$this->addElement($id);

		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idCatProduto');
		$this->addElement($id);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('codProduto');
		$item->setLabel('Código do produto:');
		$this->addElement($item);
				
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('nmProduto');
		$item->setLabel('Nome do produto:');
		$this->addElement($item);

		$item = new Zend_Dojo_Form_Element_ValidationTextBox('quantidade');
		$item->setLabel('Quantidade:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_Editor('descricao');
		$item->setLabel('Descrição:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('novidade');
		$item->setLabel('Novidade:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('oferta');
		$item->setLabel('Oferta:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('sugestao');
		$item->setLabel('Sugestão:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('ativo');
		$item->setLabel('Ativo:');
		$this->addElement($item);

		$item = new Zend_Dojo_Form_Element_CheckBox('frete');
		$item->setLabel('Frete:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('disponibilidade');
		$item->setLabel('Disponibilidade:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('preco_normal');
		$item->setLabel('Preço Normal:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('preco_opcional');
		$item->setLabel('Preço Opcional:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('prazo_entrega');
		$item->setLabel('Prazo de entrega:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('preco_opcional');
		$item->setLabel('Preço Opcional:');
		$this->addElement($item);

		$idPluginRef = new Zend_Form_Element_Hidden('idPluginRef');
		$this->addElement($idPluginRef);
						
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>