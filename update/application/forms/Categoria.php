<?php

class Application_Form_Categoria extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		$categorias = array();
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idCategoria');
		$this->addElement($id);
		
		$categoria = new Zend_Form_Element_Multiselect('categoria[]');
		$categoria->setLabel('Categoria :');
		$categoria->setRequired(true);
		$categoria->addValidator('NotEmpty', true, $aMsgError);
		$cat = new Application_Model_Imovel();
		$values = $cat->listarGrupo();
		$categoria->setMultiOptions($values);
		$this->addElement($categoria);
		
		$titulo = new Zend_Dojo_Form_Element_TextBox('nome');
		$titulo->setLabel('Nome da Categoria :');
		$titulo->setRequired(true);
		$titulo->addValidator('NotEmpty', true, $aMsgError);
		$titulo->addValidator('StringLength', true,
				array(
						'max' => 200,
						'messages' => array('stringLengthTooLong' => 'O titulo \'%value%\' não pode ser maior que 200')));
		$this->addElement($titulo);
		
		$ordem = new Zend_Dojo_Form_Element_TextBox('ordem');
		$ordem->setLabel('Ordem :');
		$ordem->setRequired(true);
		$ordem->addValidator('NotEmpty', true, $aMsgError);
		$ordem->addValidator('StringLength', true,
				array(
						'max' => 2,
						'messages' => array('stringLengthTooLong' => 'a ordem \'%value%\' não pode conter mais que 2 caracteres')));
		$this->addElement($ordem);
		
		$idTipoImovels = new Zend_Form_Element_Select('idTipoImovel');
		$idTipoImovels->setLabel('Aluguel / Venda :');
		$idTipoImovels->setRequired(true);
		$idTipoImovels->addValidator('NotEmpty', true, $aMsgError);
		$idTipoImovels->setMultiOptions(array(
				1 => 'Aluguel',
				2 => 'Venda'
		));
		$this->addElement($idTipoImovels);
		
		$item = new Zend_Dojo_Form_Element_CheckBox('status');
		$item->setLabel('Ativo :');
		$this->addElement($item);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>