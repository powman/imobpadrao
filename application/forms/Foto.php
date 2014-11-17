<?php
class Application_Form_Foto extends Zend_Form {
	public function init() {
		$aAttribs = array ('class' => 'input-medium' );
		$aMsgError = array ('messages' => array ('isEmpty' => "Preencha o campo corretamente." ) );
		
		
		$hidden = new Zend_Form_Element_Hidden('idFoto');
		$this->addElement($hidden);
		$hidden = new Zend_Form_Element_Hidden('idFotoNumeracao');
		$this->addElement($hidden);
		$hidden = new Zend_Form_Element_Hidden('idFotoAlbum');
		$this->addElement($hidden);
		 
		$titulo = new Zend_Form_Element_Text ( 'nome' );
		$titulo->setLabel ( 'Nome :' );
		$titulo->setRequired ( true );
		$titulo->setAttribs ( $aAttribs );
		$titulo->addValidator ( 'NotEmpty', true, $aMsgError );
		$titulo->addValidator ( 'StringLength', true, array ('max' => 150, 'messages' => array ('stringLengthTooLong' => 'O Nome \'%value%\' não pode ser maior que  \'%max%\' ' ) ) );
		$this->addElement ( $titulo );
		
		$resumo = new Zend_Form_Element_Textarea ( 'comentario' );
		$resumo->setLabel ( 'Comentario :' );
		$resumo->setRequired ( true );
		$resumo->setAttribs ( array ('cols' => 90, 'rows' => 8 ) );
		$resumo->addValidator ( 'NotEmpty', true, $aMsgError );
		$this->addElement ( $resumo );
		
		$item = new Zend_Form_Element_Checkbox('destaque');
		$item->setLabel('Destaque :')->setAttribs(array('class'=>'jquery_improved'));
		$this->addElement($item);

		$imagem = new Zend_Form_Element_File ( 'foto' );
		$imagem->setLabel ( 'Fotos :' );
		$imagem->setAttribs($aAttribs);
		$imagem->addValidator ( 'Count', true, array ('max' => 1, 'min' => 1, 'messages' => array (Zend_Validate_File_Count::TOO_FEW => 'Envie pelo menos 1 arquivo.', Zend_Validate_File_Count::TOO_MANY => 'Envie apenas um arquivo.' ) ) );
		$imagem->addValidator ( 'Size', true, '20MB' );
		$imagem->addValidator ( 'Extension', true, 'jpg,png,gif' );
		$this->addElement ( $imagem );
		
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Cadastrar' )->setRequired ( true )->setAttribs ( array ('class' => 'button' ) );
		$this->addElement ( $submit );
	
	}
}
?>