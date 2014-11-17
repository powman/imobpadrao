<?php
class Application_Form_Fornecedor extends Zend_Form {
	public function init() {
		$this->setMethod ( 'post' );
		$this->addElement ( 'hidden', 'id' );
		$this->addElement ( 'text', 'nome_fantasia', array ('label' => 'Nome Fantasia:', 'required' => true ) );
		$this->addElement ( 'text', 'razao_social', array ('label' => 'Razao social:', 'required' => true ) );
		$this->addElement ( 'text', 'cnpj', array ('label' => 'Cnpj:', 'required' => true ) );
		$this->addElement ( 'text', 'endereco_completo', array ('label' => 'Endereco completo:', 'required' => true ) );
		$this->addElement ( 'text', 'cep', array ('label' => 'CEP:', 'required' => true ) );
		$this->addElement ( 'text', 'contato', array ('label' => 'Contato:', 'required' => true ) );
		$this->addElement ( 'text', 'telefone1', array ('label' => 'Telefone 1:', 'required' => true ) );
		$this->addElement ( 'text', 'telefone2', array ('label' => 'Telefone 2:', 'required' => true ) );
		$this->addElement ( 'text', 'email', array ('label' => 'Digite o e-mail:', 'required' => true, 'filters' => array ('StringTrim' ), 'validators' => array ('EmailAddress' ) ) );
		$this->addElement ( 'text', 'porcentagem_desconto', array ('label' => '% de desconto:', 'required' => true ) );
		$this->addElement ( 'text', 'ramo_atividade', array ('label' => 'Tamo de atividade:', 'required' => true ) );
		$this->addElement ( 'submit', 'submit', array ('ignore' => true, 'label' => 'Cadastrar', 'class' => 'button' ) );
	}
}