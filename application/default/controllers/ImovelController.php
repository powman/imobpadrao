<?php

class ImovelController extends Zend_Controller_Action {

	public $imovelDestaque;

	public $imovel;

	public $imagemDestaque;

	public $aImagem;

	public $todasImagens;

	public $aTodasImagens;

	public $imovelMapper;

	public function init() {
		$this->imovelMapper = Application_Model_ImovelMapper::instanciar();
		$this->tipoImovel = Application_Model_TipoMapper::instanciar();
		$this->cidade = Application_Model_CidadeMapper::instanciar();
		$this->parceiros = Application_Model_ParceiroMapper::instanciar();
		
		/*
		 * Carregar tipos de im�vel cadastrados 
		 * para criar formul�rio de busca
		 */
		$aTipoImovel = array();
		$aTipoImovel = $this->tipoImovel->fetchAll(null, 'nmtipo_imovel');
		$this->view->aTipoImovel = $aTipoImovel;
		
		/**
		 * Carregar tipos de imóvel cadastrados
		 * para criar formulário de busca
		 */
		$aParceiro = array();
		$aParceiro = $this->parceiros->fetchAll();
		$this->view->aParceiro = $aParceiro;
		
		/**
		 * Carregar setores
		 */
		$cidadeModel = Application_Model_CidadeMapper::instanciar();
		$setorModel = Application_Model_BairroMapper::instanciar();
		$aCidade = $cidadeModel->fetchAll();
		
		$this->view->aCidade = $aCidade;
		
		foreach ($aCidade as $cidade) {
			$nmSetor = $setorModel->fetchAll('idCidade = ' . $cidade->getIdcidade(), 'nmsetor');
			foreach ($nmSetor as $setor) {
				$aResult[] = array('idsetor' => $setor->getIdsetor(), 'nmbairro' => $setor->getNmsetor(), 'nmcidade' => $cidade->getNmcidade());
			}
		}
		
		$this->view->aBairro = $aResult;
		
		$this->view->metapalavrachave = Zend_Registry::get('metaPgImovelChave');
		$this->view->metadescricao = Zend_Registry::get('metaPgImovelDescricao');
		$this->view->metatitle = Zend_Registry::get('metaPgImovelTitle');
	}

	public function mapaAction() {
		/**
		 * Busca coordenadas do mapa no banco de dados
		 */
		//$this->_helper->layout()->disableLayout();
		$this->view->latitude = $this->_request->getParam('latitude');
		$this->view->longitude = $this->_request->getParam('longitude');
	}

	public function indexAction() {
	
	}

	public function pesquisaAction() {
		$this->_helper->layout()->disableLayout();
		$pesqTudo = $this->getRequest()->getParam('pesquisar_tudo', 1);
		$sWhere = null;
		$sWhere .= '	not LATITUDE is null and ';
		$sWhere .= '	not LONGITUDE is null ';
		
		$nmcidade_nmbairro = $this->getRequest()->getParam('nmcidade_nmbairro', 0);
		if ($nmcidade_nmbairro) {
			$sWhere .= '	and IDSETOR = ' . $nmcidade_nmbairro . ' ';
		}
		
		$finalidade = $this->getRequest()->getParam('finalidade', 0);
		if ($finalidade) {
			$sWhere .= '	and VENDA_ALUGUEL = \'' . $finalidade . '\' ';
		}
		
		$tipo = $this->getRequest()->getParam('tipo', 0);
		if ($tipo) {
			$sWhere .= '	and IDTIPO_IMOVEL = ' . $tipo;
		}
		
		$quarto = $this->getRequest()->getParam('quartos', 0);
		if ($quarto) {
			$sWhere .= '	and quarto = ' . $quarto;
		}
		
		$suites = $this->getRequest()->getParam('suites', 0);
		if ($quarto) {
			$sWhere .= '	and suite = ' . $suites;
		}
		
		
		$valor_ini = $this->getRequest()->getParam('valor_inicial', 0);
		$valor_fin = $this->getRequest()->getParam('valor_final', 0);
		
		if ($valor_ini) {
			$vInicial = $valor_ini;
			if ($valor_fin) {
				$vFinal = $valor_fin;
			} else {
				$vFinal = $vInicial;
			}
			$sWhere .= '	and (VALOR_VENDA between ' . $vInicial . ' and ' . $vFinal;
			$sWhere .= '	or VALOR_ALUGUEL between ' . $vInicial . ' and ' . $vFinal . ')';
		}

		$aImoveis = $this->imovelMapper->fetchAll($sWhere);
		
		/*
		 * A primeira linha � composta por dois campos separados por tab
		 * 1 : um codigo de resultado dizendo se ocorreu tudo bem 1 ou se ocorreu erro 0
		 * 2 : se tudo bem outro codigo para dizer se esta pesquisando tudo 1 ou n�o 0 ou a msg de erro
		 */
		$resultado = '';
		if (count($aImoveis) <= 0) {
			$resultado = "0\t";
		} else {
			$resultado = "1\t" . ($pesqTudo ? '1' : 0);
		}
		foreach ($aImoveis as $imovel) {
			if (($imovel->getLatitude() * 1 == 0) && ($imovel->getLongitude() * 1) == 0)
				continue;
			$resultado .= "\n";
			$resultado .= $imovel->getIdimovel();
			$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar($imovel->getLatitude());
			$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar($imovel->getLongitude());
			if ($pesqTudo) {
				$iFinalidade = str_upper_lower($imovel->getVenda_aluguel());
				$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar(($iFinalidade=='2')?'Venda':'Aluguel');
				$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar($imovel->getQuarto());
				$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar($imovel->getSuite());
				$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar($imovel->getValor_venda());
				$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar($imovel->getValor_aluguel());
				$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar($imovel->getIdtipo_imovel());
				$resultado .= "\t" . $this->IMOB_pesquisa_imovel_mapa_sanitizar($imovel->getDescricao());
			}
		}
		$this->view->retorno = $resultado;
	}

	function IMOB_pesquisa_imovel_mapa_sanitizar($str) {
		$str = str_replace(array("\r\n", "\n", "\t", '\'', '  '), ' ', $str);
		return htmlentities($str);
	}
	public function destaqueAction() {
		/**
		 * Buscar im�vel onde o id foi passado via get
		 */
		$request = $this->_request;
		$imovel = new Application_Model_Imovel();
		$this->imovelMapper->find($request->getParam('id'), $imovel);
		$this->view->imovelDestaque = $imovel;
		$this->view->latitude = $imovel->getLatitude();
		$this->view->longitude = $imovel->getLongitude();
		$this->view->idImovelDestaque = $imovel->getIdimovel();
		
		/**
		 * Buscar im�veis relacionados
		 */
		$where = '(idtipo_imovel >= ' . $imovel->getIdtipo_imovel();
		$where .= ' or ';
		$where .= 'idsetor = ' . $imovel->getIdsetor();
		$where .= ' or ';
		$where .= 'idcidade = ' . $imovel->getIdcidade();
		$where .= ') and ';
		$where .= 'idimovel <> ' . $imovel->getIdimovel();
		
		$aRelacionados = $this->imovelMapper->fetchAll($where, ' idtipo_imovel asc ', 4, 0);
		$this->view->relacionados = $aRelacionados;
		
		/**
		 * Buscar imagem de destaque do im�vel.
		 */
		$aImagem = Application_Model_ImovelMapper::findImage($request->getParam('id'), true);
		foreach ($aImagem as $imagem) {
			$this->view->imagemDestaque = $imagem;
		}
		
		/**
		 * Buscar todas as imagens do im�vel
		 */
		$aTodasImagens = Application_Model_ImovelMapper::findImage($request->getParam('id'), false,100);
		$this->view->aTodasImagens = $aTodasImagens;
		
		$this->view->metadescricao = $imovel->getDescricao();
		$this->view->metatitle = $imovel->getDescricao();
	}

	/**
	 * A��o respons�vel por buscar os im�veis utilizando os
	 * par�metros enviados pela busca 
	 */
	public function buscaAction() {

		$busca = new Zend_Session_Namespace('busca');
		$parametros = new Zend_Session_Namespace('parametros');
		$request = $this->getRequest();
		
		/**
		 * Recebendo valores do post
		 */
		if($request->getPost('finalidade')){
		$busca_finalidade = $request->getPost('finalidade');
		}
		if($request->getPost('hidden_venda')){
		$busca_finalidade_venda = implode(',',$request->getPost('hidden_venda'));
		}
		if($request->getPost('hidden_tipo')){
		$busca_tipo = implode(',',$request->getPost('hidden_tipo'));
		}
		if($request->getPost('preco')){
		$busca_preco = $request->getPost('preco');
		}
		if($request->getPost('hidden_bairro')){
		$busca_bairro = $request->getPost('hidden_bairro');
		}
		if($request->getPost('hidden_cidade')){
		$busca_cidade = implode(',',$request->getPost('hidden_cidade'));
		}
		if($request->getPost('hidden_bairro')){
		$busca_bairro = implode(',',$request->getPost('hidden_bairro'));
		}
		if($request->getPost('buscaCodigo')){
			$busca_codigo = $request->getPost('buscaCodigo');
		}
		
		if ($request->isPost()) {
			/* Limpa o objeto de sess�o "$busca" */
			$busca->unsetAll();
			$parametros->unsetAll();
			$busca->post = $request->getPost(); /* Guarda o post completo */
			
			
			$busca->finalidade = $request->getPost('finalidade');
				
			/* se for tipo venda recebe array com as op��es */
			if ($request->getPost('hidden_venda'))
					$busca->hidden_venda = $request->getPost('hidden_venda');
	
			if ($request->getPost('hidden_tipo')) {
				$busca->hidden_tipo = $request->getPost('hidden_tipo');
			}
	
			/* guarda o pre�o */
			$busca->preco = $request->getPost('preco');
	
			/* guarda cidades selecionadas */
			if ($request->getPost('hidden_cidade')) {
				$busca->hidden_cidade = $request->getPost('hidden_cidade');
			}
	
			/* guarda bairros selecionados */
			if ($request->getPost('hidden_bairro')) {
				$busca->hidden_bairro = $request->getPost('hidden_bairro');
			}
			
			$aParametros = array();
			$where = null;
			
			/* condicao para venda ou aluguel */
			if (isset($busca_finalidade)) {
				$where .= ($where) ? ' and ' : '';
				$where .= ' venda_aluguel in(' . $busca_finalidade . ')';
	
				$aParametros['venda_aluguel'] = $busca_finalidade; /* Par�metro tipo */
			}
			
			/* condicao para o tipo do imovel */
			if (isset($busca_tipo)) {
				$where .= ($where) ? ' and ' : '';
				$where .= ' idtipo_imovel in(' . $busca_tipo . ')';
	
				$aParametros['tipo'] = $busca_tipo; /* Par�metro tipo */
			}
			
			/* condicao para finalidade venda */
			if(isset($busca_finalidade_venda)){
				$where .= ($where) ? ' and ' : '';
				$finalidadeVenda = explode(",",$busca_finalidade_venda);
			
				$where .= ' (';
			
				for($i=0;$i<count($finalidadeVenda);$i++){
					$where .= " categoria LIKE '%{$finalidadeVenda[$i]}%' ";
					if ($i < count($finalidadeVenda) - 1) {
						$where .= ' OR ';
					}
				}
			
				$where .= ') ';
				
				$aParametros['finalidade'] = $finalidadeVenda;
			
			}
			
			/* condicao para Codigo */
			if (isset($busca_codigo)) {
				$where .= ($where) ? ' and ' : '';
				$where .= ' idimovel in(' . $busca_codigo . ')';
			
				$aParametros['codigo'] = $busca_codigo; /* Par�metro código */
			}
			
			/* condicao para cidade */
			if (isset($busca_cidade)) {
				$where .= ($where) ? ' and ' : '';
				$where .= ' idcidade in(' . $busca_cidade . ')';
			
				$aParametros['cidade'] = $busca_cidade; /* Par�metro tipo */
			}
			
			/* condicao para bairro */
			if (isset($busca_bairro)) {
				$where .= ($where) ? ' and ' : '';
				$where .= ' idsetor in(' . $busca_bairro . ')';
			
				$aParametros['bairro'] = $busca_bairro; /* Par�metro tipo */
			}
			

			if ($this->getRequest()->getPost('preco') && $this->getRequest()->getPost('preco') != 'Preço') {
	
				$where .= ($where) ? ' and ' : '';
				switch ($this->getRequest()->getPost('preco')) {
					case 1:
						$where .= ' venda_aluguel = 1 and valor_aluguel <= 600.00 ';
						$aParametros['preco'] = ' R$0,00 a R$100,00';
						break;
					case 2:
						$where .= ' venda_aluguel = 1 and valor_aluguel >= 600.00 and valor_aluguel <= 1200.00 ';
						$aParametros['preco'] = ' R$600,00 a R$1.200,00';
						break;
					case 3:
						$where .= ' venda_aluguel = 1 and valor_aluguel >= 1200.00 and valor_aluguel <= 2400.00 ';
						$aParametros['preco'] = ' R$1.200,00 a R$2.400,00';
						break;
					case 4:
						$where .= ' venda_aluguel = 1 and valor_aluguel >= 2400.00 and valor_aluguel <= 4000.00 ';
						$aParametros['preco'] = ' R$2.400,00 a R$4.000,00';
						break;
					case 5:
						$where .= ' venda_aluguel = 1 and valor_aluguel >= 4000.00 ';
						$aParametros['preco'] = ' acima de R$4.000,00';
						break;
					case 6:
						$where .= ' venda_aluguel = 2 and valor_venda <= 100000.00 ';
						$aParametros['preco'] = ' R$0,00 a R$100.000,00';
						break;
					case 7:
						$where .= ' venda_aluguel = 2 and valor_venda >= 100000.00 and valor_venda <= 200000.00 ';
						$aParametros['preco'] = ' R$100.000,00 a R$200.000,00';
						break;
					case 8:
						$where .= ' venda_aluguel = 2 and valor_venda >= 200000.00 and valor_venda <= 300000.00 ';
						$aParametros['preco'] = ' R$200.000,00 a R$300.000,00';
						break;
					case 9:
						$where .= ' venda_aluguel = 2 and valor_venda >= 300000.00 and valor_venda <= 400000.00 ';
						$aParametros['preco'] = ' R$300.000,00 a R$400.000,00';
						break;
					case 10:
						$where .= ' venda_aluguel = 2 and valor_venda >= 400000.00 and valor_venda <= 500000.00 ';
						$aParametros['preco'] = ' R$400.000,00 a R$500.000,00';
						break;
					case 11:
						$where .= ' venda_aluguel = 2 and valor_venda >= 500000.00 ';
						$aParametros['preco'] = ' acima de R$500.000,00';
						break;
				}
	
			}
			
			$busca->where = $where;
			$parametros->parametros = $aParametros;
		
		}
		
		/* Passa os dados para view*/
		$this->view->post = "";
		$pagina = intval($this->_getParam('pagina', 1));

		$buscaMapper = Application_Model_ImovelMapper::instanciar();
		$aBuscaImovel = $buscaMapper->fetchAll($busca->where);

		$paginator = Zend_Paginator::factory($aBuscaImovel);
		/**
		 * Seta a quantidade de registros por p�gina
		 */
		$paginator->setItemCountPerPage(5);
		/**
		 * numero de paginas que ser�o exibidas
		 */
		$paginator->setPageRange(5);
		/**
		 * Seta a p�gina atual
		 */
		$paginator->setCurrentPageNumber($pagina);
		/**
		 * Passa o paginator para a view
		 */
		$this->view->buscaImovel = $paginator;
		
		$this->view->metapalavrachave = Zend_Registry::get('metaPgImovelChave');
		$this->view->metadescricao = Zend_Registry::get('metaPgImovelDescricao');
		
		
	
	}
}
