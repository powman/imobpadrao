<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	public function _initView() {
		$view = new Zend_View();
		$view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
		$view->addHelperPath(APPLICATION_PATH . '/helpers');
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		$frontController = Zend_Controller_Front::getInstance();
		$layoutModulePlugin = new Application_Model_Layout();
		$layoutModulePlugin->registerModuleLayout('default', APPLICATION_PATH . '/default/layouts/scripts/', 'layout');
		$layoutModulePlugin->registerModuleLayout('admin', APPLICATION_PATH . '/admin/layouts/scripts/', 'layout');
		$layoutModulePlugin->registerModuleLayout('facebook', APPLICATION_PATH . '/facebook/layouts/scripts/', 'layout');
		$layoutModulePlugin->registerModuleLayout('login', APPLICATION_PATH . '/login/layouts/scripts/', 'layout');
		$frontController->registerPlugin($layoutModulePlugin);
		require_once 'funcoes.php';
		
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/layout.ini');
		
		/*Topo*/
		Zend_Registry::set('backgroundTopo', $config->layout->backgroundTopo);
		Zend_Registry::set('backgroudFxTopo', $config->layout->backgroudFxTopo);
		/*Rodape*/
		Zend_Registry::set('backgroundRodape', $config->layout->backgroundRodape);		
		Zend_Registry::set('iconeRodapeA', $config->layout->iconeRodape->a);
		Zend_Registry::set('iconeRodapeAHover', $config->layout->iconeRodape->aHover);
		Zend_Registry::set('colorTxtRodape', $config->layout->colorTxtRodape);
		/*Menu Topo*/
		Zend_Registry::set('menuA', $config->layout->menu->a);
		Zend_Registry::set('menuAHover', $config->layout->menu->aHover);
		/*Seta Parceiro*/
		Zend_Registry::set('colorSetaParceirosA', $config->layout->colorSetaParceiros->a);
		Zend_Registry::set('colorSetaParceirosAHover', $config->layout->colorSetaParceiros->aHover);
 		
		/*Menu Icones*/
		Zend_Registry::set('iconeA', $config->layout->icone->a);
 		/*Banner*/
		Zend_Registry::set('backgroudBanner', $config->layout->backgroudBanner);

		/*Busca*/
		Zend_Registry::set('backgroudBusca', $config->layout->backgroudBusca);
		Zend_Registry::set('colorTxTituloBusca', $config->layout->colorTxTituloBusca);
		Zend_Registry::set('colorSubtituloBusca', $config->layout->colorSubtituloBusca);
		/*Botão Formulario de Busca*/
		Zend_Registry::set('backgroudBotBusca', $config->layout->backgroudBotBusca);
		Zend_Registry::set('colorBotBusca', $config->layout->colorBotBusca);
 		/*Meio*/
		Zend_Registry::set('backgroudMeio', $config->layout->backgroudMeio);
		Zend_Registry::set('backgroundBlocoImob', $config->layout->backgroundBlocoImob);
		/*Abas do imovel*/
		Zend_Registry::set('backgroudAbaImobA', $config->layout->backgroudAbaImob->a);
		Zend_Registry::set('backgroudAbaImobAHover', $config->layout->backgroudAbaImob->aHover);
		Zend_Registry::set('colorAbaA', $config->layout->colorAbaImob->a);
		Zend_Registry::set('colorAbaAHover', $config->layout->colorAbaImob->aHover);
		/*contato*/
		Zend_Registry::set('colorEnviarContato', $config->layout->colorEnviarContato);
		Zend_Registry::set('backgroundEnviarContato', $config->layout->backgroundEnviarContato);
		/*Imoveis*/
		Zend_Registry::set('backgroundImgImob', $config->layout->backgroundImgImob);
		Zend_Registry::set('colorTituloImob', $config->layout->colorTituloImob);
		Zend_Registry::set('colorDescricaoImob', $config->layout->colorDescricaoImob);
		Zend_Registry::set('colorPrecoImob', $config->layout->colorPrecoImob);
		/*Paginação*/
		Zend_Registry::set('backgroundPgPersonalizadaA', $config->layout->backgroundPgPersonalizada->a);
		Zend_Registry::set('backgroundPgPersonalizadaAHover', $config->layout->backgroundPgPersonalizada->aHover);
		Zend_Registry::set('colorPaginacao', $config->layout->colorPaginacao);
		/*Detalhes do Imovel*/
		Zend_Registry::set('colorTituloPgDetalhes', $config->layout->colorTituloPgDetalhes);
		Zend_Registry::set('borderTituloPgDetalhes', $config->layout->borderTituloPgDetalhes);
		Zend_Registry::set('colorTxtDescricaoDetalhes', $config->layout->colorTxtDescricaoDetalhes);
		Zend_Registry::set('backgroundBotDetalhes', $config->layout->backgroundBotDetalhes);
		Zend_Registry::set('colorTxtDetalhes', $config->layout->colorTxtDetalhes);
		Zend_Registry::set('borderPgDetalhes', $config->layout->borderPgDetalhes);
		/*Menu Detalhes do Imovel*/
		Zend_Registry::set('backgroudAbaMenuDetalhesA', $config->layout->backgroudAbaMenuDetalhes->a);
		Zend_Registry::set('backgroudAbaMenuDetalhesAHover', $config->layout->backgroudAbaMenuDetalhes->aHover);
		
		Zend_Registry::set('colorMenuDetalhesA', $config->layout->colorMenuDetalhes->a);
		Zend_Registry::set('colorAbaMenuDetalhesAHover', $config->layout->colorAbaMenuDetalhes->aHover);
		/*Página internas*/
		Zend_Registry::set('colorTxtInternas', $config->layout->colorTxtInternas);
				Zend_Registry::set('colorTxtTituloPadrao', $config->layout->colorTxtTituloPadrao);
		
		/* Configuração do site e dos emails */
		$configSite = new Zend_Config_Ini(APPLICATION_PATH . '/configs/configuracao.ini');
		$emailsAgende = array();
		$emailsAgende = explode(",", trim($configSite->conf->email->agendeumavisita));
		/* Emails Agende uma Visita */
		Zend_Registry::set('emailsAgende', $emailsAgende);
		
		$emailsLigue = array();
		$emailsLigue = explode(",", trim($configSite->conf->email->ligamospravoce));
		/* Emails Ligamos para você */
		Zend_Registry::set('emailsLigue', $emailsLigue);

		$emailsContato = array();
		$emailsContato = explode(",", trim($configSite->conf->email->contato));
		/* Emails Ligamos para você */
		Zend_Registry::set('emailsContato', $emailsContato);
		
		
		
		/* url do boleto */
		Zend_Registry::set('url2viaBoleto', $configSite->conf->url->segundavia);
		
		/* Latitude Empresa */
		Zend_Registry::set('empresaLatitude', $configSite->conf->mapa->latitude);
		
		/* Longitude Empresa */
		Zend_Registry::set('empresaLongitude', $configSite->conf->mapa->longitude);

		
		/* DADOS DA EMPRESA */

		/* Nome da Empresa */
		Zend_Registry::set('nomeEmpresa', $configSite->conf->nome->empresa);

		/* Email Empressa */
		Zend_Registry::set('empresaEmail', $configSite->conf->email->empresa);

		/* Telefone Empressa */
		Zend_Registry::set('empresaTelefone', $configSite->conf->telefone->empresa);

		/* Cidade Empresa */
		Zend_Registry::set('empresaCidade', $configSite->conf->cidade->empresa);

		/* UF Empresa */
		Zend_Registry::set('empresaUf', $configSite->conf->uf->empresa);

		/* Setor Empresa */
		Zend_Registry::set('empresaSetor', $configSite->conf->setor->empresa);

		/* Setor Empresa */
		Zend_Registry::set('empresaEndereco', $configSite->conf->endereco->empresa);

		
		/* DADOS DA REDE SOCIAL */
		
		/* Facebook */
		Zend_Registry::set('redeFacebook', $configSite->conf->rede->facebook);
		
		/* Twitter */
		Zend_Registry::set('redeTwitter', $configSite->conf->rede->twitter);

		/* Youtube */
		Zend_Registry::set('redeYoutube', $configSite->conf->rede->youtube);

		/* linkedin */
		Zend_Registry::set('redeLinkedin', $configSite->conf->rede->linkedin);
		
		
		/* DADOS DO META TAGS */
		
		$configMeta = new Zend_Config_Ini(APPLICATION_PATH . '/configs/metatags.ini');
		/* Pagina Inicial */
		Zend_Registry::set('metaPgInicialChave', $configMeta->conf->meta->inicial->palavrachave);
		Zend_Registry::set('metaPgInicialDescricao', $configMeta->conf->meta->inicial->descricao);
		Zend_Registry::set('metaPgInicialTitle', $configMeta->conf->meta->inicial->title);
		
		/* Pagina Empresa */
		Zend_Registry::set('metaPgEmpresaChave', $configMeta->conf->meta->empresa->palavrachave);
		Zend_Registry::set('metaPgEmpresaDescricao', $configMeta->conf->meta->empresa->descricao);
		Zend_Registry::set('metaPgEmpresaTitle', $configMeta->conf->meta->empresa->title);

		/* Pagina Servicos */
		Zend_Registry::set('metaPgServicoChave', $configMeta->conf->meta->servico->palavrachave);
		Zend_Registry::set('metaPgServicoDescricao', $configMeta->conf->meta->servico->descricao);
		Zend_Registry::set('metaPgServicoTitle', $configMeta->conf->meta->servico->title);
		
		/* Pagina Contato */
		Zend_Registry::set('metaPgContatoChave', $configMeta->conf->meta->contato->palavrachave);
		Zend_Registry::set('metaPgContatoDescricao', $configMeta->conf->meta->contato->descricao);
		Zend_Registry::set('metaPgContatoTitle', $configMeta->conf->meta->contato->title);
		
		/* Pagina imovel */
		Zend_Registry::set('metaPgImovelChave', $configMeta->conf->meta->imovel->palavrachave);
		Zend_Registry::set('metaPgImovelDescricao', $configMeta->conf->meta->imovel->descricao);
		Zend_Registry::set('metaPgImovelTitle', $configMeta->conf->meta->imovel->title);
	}

	public function _initSession() {
		$applicationSession = new Zend_Session_Namespace('Autorizacao');				
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$auth = Zend_Auth::getInstance()->getIdentity();						
			switch ($auth->idPerfil) {
				case 1:
					$applicationSession->userRole = 'admin';
					break;
				case 2:
					$applicationSession->userRole = 'usuario';
					break;
				default:
					$applicationSession->userRole = 'guest';
					break;
			}
		} else {
			$applicationSession->userRole = 'guest';
		}
	}

	public function _initFrontControllerPlugin() {
		$front = Zend_Controller_Front::getInstance();
		require_once APPLICATION_PATH . '/plugin/ACL.php';
		require_once APPLICATION_PATH . '/plugin/Canvas.php';
		$front->registerPlugin(new Application_Plugin_Acl());
	}

	public function _initAuth() {
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			/*return $this->_helper->redirector->goToRoute ( array ('controller' => 'index', 'module' => 'login' ), null, true );*/
		}
	}

	public function _initACL() {
		$acl = new Zend_Acl();
		$guestRole = new Zend_Acl_Role('guest');
		$userRole = new Zend_Acl_Role('usuario');
		$adminRole = new Zend_Acl_Role('admin');
		
		$acl->addRole($guestRole);
		$acl->addRole($userRole, $guestRole);
		$acl->addRole($adminRole, $userRole);
		
		Zend_Registry::set('ACL', $acl);
	}
}

