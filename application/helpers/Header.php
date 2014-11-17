<?php

class Zend_View_Helper_Header extends Zend_View_Helper_Abstract {

	public function header() {
		$fc = Zend_Controller_Front::getInstance()->getRequest();
		$output = '';
		if ($fc->getControllerName() == 'imovel' && $fc->getActionName() == 'destaque' && $fc->getModuleName() == 'default') {
			$tipoImovelMapper = Application_Model_TipoMapper::instanciar();
			$imovelNome = new Application_Model_Tipo();
			$tipoImovelMapper->find($this->view->imovelDestaque->getIdtipo_imovel(), $imovelNome);
			
			/* Buscando o nome do bairro */
			$bairroImovelMapper = Application_Model_BairroMapper::instanciar();
			$bairroNome = new Application_Model_Bairro();
			$bairroImovelMapper->find($this->view->imovelDestaque->getIdsetor(), $bairroNome);
			
			$sTitle = $imovelNome->getNmtipo_imovel() . ' - ';
			$sTitle .= $bairroNome->getNmsetor() . ' ';
			if ($this->view->imovelDestaque->getQuarto() > 0)
				$sTitle .= $this->view->imovelDestaque->getQuarto() . ' quarto(s) ';
			if ($this->view->imovelDestaque->getSuite() > 0)
				$sTitle .= $this->view->imovelDestaque->getSuite() . ' suite(s) ';
			
			$output = '<title>' . $sTitle . '</title>';
			$output .= '<meta name="title" content="' . $imovelNome->getNmtipo_imovel() . '" >';
			$output .= '<meta name="description" content="' . $this->view->imovelDestaque->getDescricao() . '">';
			$output .= '<meta property="og:title" content="' . $sTitle . '" >';
			$output .= '<meta property="og:type" content="website">';
			$output .= '<meta property="og:description" content="' . $this->view->imovelDestaque->getDescricao() . '" >';
			/* Se não existir imagem, exibe imagem padrão*/
			if (!$this->view->imagemDestaque)
				$this->view->imagemDestaque = 'sem_imagem_detalhe.png';
			$sUrl = 'http://tradicaoimoveisgo.com.br/';
			$output .= '<meta property="og:image" content="' . $sUrl . $this->view->baseUrl() . '/media/upload/imagens/';
			$output .= $this->view->imagemDestaque . '" >';
			$output .= '<meta property="og:site_name" content="' . $sTitle . '" >';
		} else {
			$aMetaMapper = Application_Model_SeoMapper::instanciar();
			$aMeta = end($aMetaMapper->fetchAll('nmpagina like\'%' . $fc->getControllerName() . '%\''));			
			if($aMeta){
				$output = '<title>::: TRADIÇÃO IMÓVEIS :::</title>';
				$output .= '<meta name="title" content="' . $aMeta->getMetaTitle() . '" >';
				$output .= '<meta name="description" content="' . $aMeta->getMetaDescription() . '">';
				$output .= '<meta name="keywords" content="' . $aMeta->getMetaKeywords() . '" >';
			}else{
				$output = '<title>::: TRADIÇÃO IMÓVEIS :::</title>';
				$output .= '<meta name="title" content="::: TRADIÇÃO IMÓVEIS :::" >';
				$output .= '<meta name="description" content="Empresa do ramo imobiliário especiazada em venda e locação de imóveis em goiânia - goias. SEU FUTURO. NOSSA TRADIÇÃO">';
				$output .= '<meta name="keywords" content="imoveis, imobiliaria, imobiliaria goiânia, imobiliaria de goiânia, imobiliaria goiania, imobiliaria de goiania, goiânia, goiania , goias, casas, lotes, apartamentos, tradição, Tradição imoveis, casa, lote, apartamento, Aluguel goiania, Aluguel goiânia, Venda de imoveis, Venda goiania, Venda goiânia, Sobrado, Sobrado em goiania," >';
				
			}
		
		}
		return $output;
	}
}