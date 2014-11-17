<?php

class Application_Form_Pessoa extends Zend_Dojo_Form {

	public function init() {
		$this->setMethod('POST');
		$this->setAttrib('onSubmit', 'teste()');
		$aAttribs = array('class' => 'input-medium');
		$aMsgError = array('messages' => array('isEmpty' => "Preencha o campo corretamente."));
		
		$this->setMethod('post');
		$id = new Zend_Form_Element_Hidden('idPessoa');
		$this->addElement($id);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('nome');
		$item->setLabel('Nome:');
		$this->addElement($item);
		
		$item = new Zend_Form_Element_Select('tipo');
		$item->setLabel('Tipo:');
		$item->addMultiOptions(Admin_PessoaController::$aTipo);
		$this->addElement($item);
		
		$item = new Zend_Form_Element_Select('sexo');
		$item->setLabel('Sexo:');
		$item->addMultiOptions(Admin_PessoaController::$aSexo);
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('cpf_cnpj');
		$item->setLabel('CPF/CNPJ:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('rg');
		$item->setLabel('RG:');		
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('telefone1');
		$item->setLabel('Telefone 1:');		
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('telefone2');
		$item->setLabel('Telefone 2:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('celular');
		$item->setLabel('Celular:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('email');
		$item->setLabel('Email:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_DateTextBox('dtnascimento');
		$item->setLabel('Data de Nascimento:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('razao_social');
		$item->setLabel('Raz�o Social:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('nome_fantasia');
		$item->setLabel('Nome Fantasia:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('incsEstadual');
		$item->setLabel('Inscri��o Estadual:');
		$this->addElement($item);
		
		$item = new Zend_Dojo_Form_Element_ValidationTextBox('incsMunicipal');
		$item->setLabel('Inscri��o Municipal:');
		$this->addElement($item);
		
		/*
		 * Fieldset Endere�o Pessoal
		 */
		$cep = new Zend_Dojo_Form_Element_ValidationTextBox('cep', array('label' => 'Cep:', 'class' => 'input'));
		$logradouro = new Zend_Dojo_Form_Element_ValidationTextBox('logradouro', array('label' => 'Logradouro:', 'class' => 'input'));
		$bairro = new Zend_Dojo_Form_Element_ValidationTextBox('bairro', array('label' => 'Bairro:', 'class' => 'input'));
		$tipo = new Zend_Form_Element_Hidden('tipoEndereco', array('class' => 'input', 'value' => 1));
		$numero = new Zend_Dojo_Form_Element_ValidationTextBox('numero', array('label' => 'N�mero:', 'class' => 'input'));
		$complemento = new Zend_Dojo_Form_Element_ValidationTextBox('complemento', array('label' => 'Complemento:', 'class' => 'input'));
		
		$cidade = new Zend_Form_Element_Select('cidade', array('label' => 'Cidade:', 'class' => 'input'));
		$cidadeMapper = Application_Model_CidadeMapper::instanciar();
		$aCidade = $cidadeMapper->fetchAll();
		foreach ($aCidade as $sCidade) {
			$cidade->addMultiOption($sCidade->getIdCidade(), $sCidade->getNmcidade());
		}
		
		$aElements = array($cep, $logradouro, $numero, $bairro, $tipo, $complemento, $cidade);
		$this->addElements($aElements);
		$display = array('cep', 'logradouro', 'numero', 'bairro', 'tipoEndereco', 'complemento', 'cidade');
		$this->addDisplayGroup($display, 'enderecoPessoal', array("legend" => "Endere�o Pessoal"));
		
		/*
		 * Fieldset Endere�o Comercial
		 */
		$cep = new Zend_Dojo_Form_Element_ValidationTextBox('cepComercial', array('label' => 'Cep:', 'class' => 'input'));
		$logradouro = new Zend_Dojo_Form_Element_ValidationTextBox('logradouroComercial', array('label' => 'Logradouro:', 'class' => 'input'));
		$bairro = new Zend_Dojo_Form_Element_ValidationTextBox('bairroComercial', array('label' => 'Bairro:', 'class' => 'input'));
		$tipo = new Zend_Form_Element_Hidden('tipoEnderecoComercial', array('class' => 'input', 'value' => 1));
		$numero = new Zend_Dojo_Form_Element_ValidationTextBox('numeroComercial', array('label' => 'N�mero:', 'class' => 'input'));
		$complemento = new Zend_Dojo_Form_Element_ValidationTextBox('complementoComercial', array('label' => 'Complemento:', 'class' => 'input'));
		
		$cidade = new Zend_Form_Element_Select('cidadeComercial', array('label' => 'Cidade:', 'class' => 'input'));
		$cidadeMapper = Application_Model_CidadeMapper::instanciar();
		$aCidade = $cidadeMapper->fetchAll();
		foreach ($aCidade as $sCidade) {
			$cidade->addMultiOption($sCidade->getIdCidade(), $sCidade->getNmcidade());
		}
		
		$aElements = array($cep, $logradouro, $numero, $bairro, $tipo, $complemento, $cidade);
		$this->addElements($aElements);
		$display = array(
						'cepComercial', 
						'logradouroComercial', 
						'numeroComercial', 
						'bairroComercial', 
						'tipoEnderecoComercial', 
						'complementoComercial', 
						'cidadeComercial');
		$this->addDisplayGroup($display, 'enderecoComercial', array("legend" => "Endere�o Comercial"));
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Cadastrar')->setRequired(true)->setAttribs(array('class' => 'button'));
		$this->addElement($submit);
	
	}
}
?>