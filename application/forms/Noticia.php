<?php

class Application_Form_Noticia extends Zend_Form {

	public function init() {
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		
		$idNoticia = new Zend_Form_Element_Hidden('idNoticia');
		$this->addElement($idNoticia);
				
		$categoria = new Zend_Form_Element_Select('idNoticiaCategoria');
		$categoria->setLabel('Categoria :');
		$categoria->setRequired(true);
		$categoria->addValidator('NotEmpty', true, $aMsgError);
		$cat = Application_Model_CategoriaMapper::instanciar();
		foreach ($cat->fetchAll() as $row) {
			$categoria->addMultiOption($row->getIdNoticiaCategoria(), $row->getNomeCategoria());
		}
		$this->addElement($categoria);
		
		$titulo = new Zend_Dojo_Form_Element_TextBox('titulo');
		$titulo->setLabel('Titulo :');
		$titulo->setRequired(true);		
		$titulo->addValidator('NotEmpty', true, $aMsgError);
		$titulo->addValidator('StringLength', true, 
							array(
								'max' => 200, 
								'messages' => array('stringLengthTooLong' => 'O titulo \'%value%\' não pode ser maior que 200')));
		$this->addElement($titulo);
		
		$dtnoticia = new Zend_Dojo_Form_Element_DateTextBox('dtnoticia');
		$dtnoticia->setLabel('Data da notícia :');
		$dtnoticia->setRequired(true);		
		$dtnoticia->addValidator('NotEmpty', true, $aMsgError);
		/*$sData = "A data informada '%value%' não e válida. Ex: '%format%'";
		$dataFormat = new Zend_Validate_Date();
		$dataFormat->setFormat('mm/dd/YY');
		$dtnoticia->addValidator($dataFormat);*/
		$this->addElement($dtnoticia);
		
		$fonte = new Zend_Dojo_Form_Element_TextBox('fonte');
		$fonte->setLabel('Fonte :');
		$fonte->setRequired(true);		
		$fonte->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($fonte);
		
		$resumo = new Zend_Form_Element_FCKEditor('resumo');
		$resumo->setLabel('Resumo :');
		$resumo->setRequired(true);
		$resumo->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($resumo);
		
		
		$texto = new Zend_Form_Element_FCKEditor('texto');
		$texto->setLabel('Notícia :');
		$texto->setAttribs(array('ToolbarSet'=>'Default','Width'=>'100%','Height'=>'500'));
		$texto->setRequired(true);
		$texto->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($texto);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>