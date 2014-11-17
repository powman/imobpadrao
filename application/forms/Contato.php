<?php
class Application_Form_Contato extends Zend_Form {
	public function init() {
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		$ValidarEmail = new Zend_Validate_EmailAddress();
		$ValidarEmail->setMessage('\'%value%\' não é um e-mail valido. Ex: usuario@dominio.com',Zend_Validate_EmailAddress::INVALID_FORMAT);
		$this->setMethod('post');
		
		$nome = new Zend_Form_Element_Text('nome');
		$nome->setLabel('Nome :');
		$nome->setRequired(true);
		$nome->setAttribs(array('size'=>70));
		$nome->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($nome);
		
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('E-mail :');
		$email->setRequired(true);
		$email->addValidator('NotEmpty', true, $aMsgError);
		$email->addValidator($ValidarEmail);
		$email->setFilters(array('StringTrim'));
		$this->addElement($email);
		
		$telefone = new Zend_Form_Element_Text('telefone');
		$telefone->setLabel('Telefone :');
		$telefone->setRequired(true);
		$telefone->setAttribs(array('size'=>70));
		$telefone->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($telefone);
		
		$assunto = new Zend_Form_Element_Text('assunto');
		$assunto->setLabel('Assunto :');
		$assunto->setRequired(true);
		$assunto->setAttribs(array('size'=>70));
		$assunto->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($assunto);
		
		$mensagem = new Zend_Form_Element_Textarea('mensagem');
		$mensagem->setLabel('Mensagem:');
		$mensagem->setRequired(true);
		$mensagem->setAttribs(array('cols'=>53, 'rows'=>10));
		$mensagem->addValidator('NotEmpty', true, $aMsgError);
		$this->addElement($mensagem);
		

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Enviar');
		$submit->setRequired(true);
		$submit->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
		
	}
}
?>