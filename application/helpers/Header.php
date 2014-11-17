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
			/* Se n�o existir imagem, exibe imagem padr�o*/
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
				$output = '<title>::: TRADI��O IM�VEIS :::</title>';
				$output .= '<meta name="title" content="' . $aMeta->getMetaTitle() . '" >';
				$output .= '<meta name="description" content="' . $aMeta->getMetaDescription() . '">';
				$output .= '<meta name="keywords" content="' . $aMeta->getMetaKeywords() . '" >';
			}else{
				$output = '<title>::: TRADI��O IM�VEIS :::</title>';
				$output .= '<meta name="title" content="::: TRADI��O IM�VEIS :::" >';
				$output .= '<meta name="description" content="Empresa do ramo imobili�rio especiazada em venda e loca��o de im�veis em goi�nia - goias. SEU FUTURO. NOSSA TRADI��O">';
				$output .= '<meta name="keywords" content="imoveis, imobiliaria, imobiliaria goi�nia, imobiliaria de goi�nia, imobiliaria goiania, imobiliaria de goiania, goi�nia, goiania , goias, casas, lotes, apartamentos, tradi��o, Tradi��o imoveis, casa, lote, apartamento, Aluguel goiania, Aluguel goi�nia, Venda de imoveis, Venda goiania, Venda goi�nia, Sobrado, Sobrado em goiania," >';
				
			}
		
		}
		return $output;
	}
}