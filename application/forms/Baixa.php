<?php
class Application_Form_Baixa extends Zend_Form {
	public function init() {
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		$ValidarEmail = new Zend_Validate_EmailAddress();
		$ValidarEmail->setMessage('\'%value%\' não é um e-mail valido. Ex: usuario@dominio.com',Zend_Validate_EmailAddress::INVALID_FORMAT);
		$this->setMethod('post');
		
		$nomeFuncionario= new Zend_Form_Element_Text('nomeFuncionario');
		$nomeFuncionario->setLabel('Nome do Funcionário:*');
		$nomeFuncionario->setRequired(true);
		$nomeFuncionario->setAttribs(array('size'=>70));
		$nomeFuncionario->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nomeFuncionario);
		
		$nomeCondominio= new Zend_Form_Element_Text('nomeCondominio');
		$nomeCondominio->setLabel('Nome do Condomínio:*');
		$nomeCondominio->setRequired(true);
		$nomeCondominio->setAttribs(array('size'=>70));
		$nomeCondominio->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nomeCondominio);
		
		$cnpj= new Zend_Form_Element_Text('cnpj');
		$cnpj->setLabel('CNPJ do condomínio:*');
		$cnpj->setRequired(true);
		$cnpj->setAttribs(array('size'=>70));
		$cnpj->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($cnpj);

		$telefone = new Zend_Form_Element_Text('telefone');
		$telefone->setLabel('Telefone :*');
		$telefone->setRequired(true);
		$telefone->addValidator('NotEmpty', true, $aMsgError);
		$telefone->setAttribs(array('size'=>70));
		$this->addElement($telefone);
		
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('E-mail :*');
		$email->setRequired(true);
		$email->addValidator('NotEmpty', true, $aMsgError);
		$email->addValidator($ValidarEmail);
		$email->setFilters(array('StringTrim'));
		$this->addElement($email);
		
		$dataExclusao = new Zend_Form_Element_Text('dataExclusao');
		$dataExclusao->setLabel('Data de exclusão :*');
		$dataExclusao->setRequired(true);
		$dataExclusao->setAttribs(array('size'=>70));
		$dataExclusao->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($dataExclusao);
		
		$obs = new Zend_Form_Element_Textarea('observacao');
		$obs->setLabel('Observação:');
		$obs->setRequired(true);
		$obs->setAttribs(array('cols'=>53, 'rows'=>10));
		$obs->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($obs);
		

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Enviar');
		$submit->setRequired(true);
		$submit->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
		
	}
}
?>