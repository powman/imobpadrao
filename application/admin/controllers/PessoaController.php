<?php

class Admin_PessoaController extends Zend_BaseController {

	public static $aTipo = array(0 => '', 1 => 'Cliente', 2 => 'Vendedor');

	public static $tipoCliente = 1;

	public static $tipoVendedor = 2;

	public static $aSexo = array(0 => '', 1 => 'Masculino', 2 => 'Feminino');

	public function incluirAction() {
		
		$this->view->headerText = 'Cadastro de ' . strtolower($this->_labelController);
		if ($this->getRequest()->isPost()) {
			print_rpre($this->getRequest()->getParams());
			if ($this->_form->isValid($this->getRequest()->getPost())) {
				try {
					
					$pessoaSave = new Application_Model_Pessoa($this->getRequest()->getParams());
					$idCliente = $this->_mapper->save($pessoaSave);
					
					/*
					 * Telefones
					 */
					if($this->getRequest()->getParam('telefone1')){ //verifica se foi passado algum telefone no campo
						$aTelefone1 = array(
											'idPessoa'=>$idCliente,
											'numero' => $this->getRequest()->getParam('telefone1'),
											'tipo' => 1 //onde tipo 1 = residencial e tipo 2 = celular
						);
					}
					
					if($this->getRequest()->getParam('telefone2')){ //verifica se foi passado algum telefone no campo
						$aTelefone2 = array(
											'idPessoa'=>$idCliente,
											'numero' => $this->getRequest()->getParam('telefone2'),
											'tipo' => 1
						);					
					};
					if($this->getRequest()->getParam('celular')){ //verifica se foi passado algum telefone no campo
						$aCelular = array(
											'idPessoa'=>$idCliente,
											'numero' => $this->getRequest()->getParam('celular'),
											'tipo' => 2
						);
					};						
					
					$telefone1Save = new Application_Model_Telefone($aTelefone1); 
					$telefone2Save = new Application_Model_Telefone($aTelefone2);
					$celularSave = new Application_Model_Telefone($aCelular);
					$telefoneMapper = Application_Model_TelefoneMapper::instanciar(); 
					$telefoneMapper->save($telefone1Save); 
					$telefoneMapper->save($telefone2Save); 
					$telefoneMapper->save($celularSave); 
					
					/**
					 * @var $aEnderecoPessoal array
					 * usada para separar endere�o pessoal de endere�o comercial
					 */
					$aEnderecoPessoal = array(
												'idCliente' => $idCliente, 
												'idCidade' => $this->getRequest()->getParam('cidade'), 
												'tipoEndereco' => 1, 
												'logradouro' => $this->getRequest()->getParam('logradouro'), 
												'bairro' => $this->getRequest()->getParam('bairro'), 
												'numero' => $this->getRequest()->getParam('numero'), 
												'complemento' => $this->getRequest()->getParam('complemento'), 
												'cep' => $this->getRequest()->getParam('cep'));
					/*
					 * Gravando endere�o pessoal
					 */
					$enderecoPessoalSave = new Application_Model_Endereco($aEnderecoPessoal);
					$enderecoMapper = Application_Model_EnderecoMapper::instanciar();
					$enderecoMapper->save($enderecoPessoalSave);
					
					/**
					 * @var $aEnderecoPessoal array
					 * usada para separar endere�o pessoal de endere�o comercial
					 */
					$aEnderecoComercial = array(
													'idCliente' => $idCliente, 
													'idCidade' => $this->getRequest()->getParam('cidadeComercial'), 
													'tipoEndereco' => 2, 
													'logradouro' => $this->getRequest()->getParam('logradouroComercial'), 
													'bairro' => $this->getRequest()->getParam('bairroComercial'), 
													'numero' => $this->getRequest()->getParam('numeroComercial'), 
													'complemento' => $this->getRequest()->getParam('complementoComercial'), 
													'cep' => $this->getRequest()->getParam('cepComercial'));
					/*
					 * Gravando endere�o comercial
					 */
					$enderecoComercialSave = new Application_Model_Endereco($aEnderecoComercial);
					$enderecoMapper->save($enderecoComercialSave);
				
				} catch (Exception $e) {
					$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
				}
			} else {
				$this->_helper->FlashMessenger(array('warning' => 'Alguns erros foram encontrado no formulário.'));
			}
			if ($this->_debug)
				print_rpre($this->_form->getValues());
		}
		$this->view->form = $this->_form;
	}

}
