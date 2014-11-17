<?php

class IndexController extends Zend_BaseController {

	public $imovel_venda;

	protected $_labelController = 'Imobiliárias';

	public function init() {
		$this->tipoImovel = Application_Model_TipoMapper::instanciar();
		$this->imovel_venda = Application_Model_ImovelMapper::instanciar();
		$this->banners = Application_Model_BannerMapper::instanciar();
		$this->categorias = Application_Model_CategoriaMapper::instanciar();
		$this->parceiros = Application_Model_ParceiroMapper::instanciar();
		$this->cidade = Application_Model_CidadeMapper::instanciar();


		/**
		 * Carregar tipos de imóvel cadastrados 
		 * para criar formulário de busca
		 */
		$aTipoImovel = array();
		$aTipoImovel = $this->tipoImovel->fetchAll();
		$this->view->aTipoImovel = $aTipoImovel;

		/**
		 * Carregar tipos de imóvel cadastrados
		 * para criar formulário de busca
		 */
		$aParceiro = array();
		$aParceiro = $this->parceiros->fetchAll();
		$this->view->aParceiro = $aParceiro;
		
		/**
		 * Carregar cidades
		 */
		$aCidade = array();
		$aCidade = $this->cidade->fetchAll();
		$this->view->aCidade = $aCidade;
		
		/**
		 * Carregar setores
		 */
		$cidadeModel = Application_Model_CidadeMapper::instanciar();
		$setorModel = Application_Model_BairroMapper::instanciar();
		$aCidade = $cidadeModel->fetchAll();
		foreach($aCidade as $cidade) {
			$nmSetor = $setorModel->fetchAll('idCidade = ' . $cidade->getIdcidade());
			foreach ($nmSetor as $setor){
				$aResult[] = array(
					'idsetor'=>$setor->getIdsetor(),
					'nmbairro'=>$setor->getNmsetor(),
					'nmcidade'=>$cidade->getNmcidade()
				); 
			}
		}
		
		$this->view->aBairro = $aResult;
		$this->view->metapalavrachave = Zend_Registry::get('metaPgInicialChave');
		$this->view->metadescricao = Zend_Registry::get('metaPgInicialDescricao');
		$this->view->metatitle = Zend_Registry::get('metaPgInicialTitle');
	}

	public function indexAction() {
		
		
		/**	
		 * Carregar banners cadastrados
		 */
		$aBanner = array();
		$aBanner = $this->banners->fetchAll('status = 1');
		$this->view->aBanners = $aBanner;
		
		/**
		 * Carregar categorias carregadas
		 */
		$aCategoria = array();
		$aCategoria = $this->categorias->fetchAll('status = 1','ordem ASC');
		$this->view->aCategorias = $aCategoria;
		
		$this->view->paginator = '';
		$aItens = array();
		$this->view->pagina = intval($this->_getParam('pagina', 1));
		$this->view->tipo = $this->_getParam('tipo');

	}

	public function setorAction() {
		$resposta = array();
		
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		$sCidade = $this->_request->getParam('id');
		$bairroModel = Application_Model_BairroMapper::instanciar();
		$aBairro = $bairroModel->fetchAll('idcidade in(' . $sCidade . ')');	
		
		$sCidade2 = array();
		$i = 0;
		foreach ($aBairro as $sCidade){
			$sCidade2[$i]['idSetor'] = $sCidade->getIdsetor();
			$sCidade2[$i]['nmSetor'] = $sCidade->getNmsetor();
			$i++;
		}
		
		if (!count($sCidade2)) {
			$resposta['situacao'] = "error";
			$resposta['msg'] = "Erro ao enviar.";
		} else {
			$resposta['situacao'] = "sucess";
			$resposta['bairros'] = $sCidade2;
			$resposta['num'] = count($sCidade2);
			$resposta['msg'] = "Enviado com sucesso.";
		}
		
		echo json_encode($resposta);
	}
	
	public function localizarsetorAction() {
		
		$this->_helper->layout()->disableLayout();
		$sCidade = $this->_request->getParam('id');
		$bairroModel = Application_Model_BairroMapper::instanciar();
		$aBairro = $bairroModel->fetchAll('idcidade in(' . $sCidade . ')');		
		$this->view->aBairro = $aBairro;
	}
	
	public function mapaAction() {
	

	}
}