<?php

class Application_Model_ImovelMapper extends Application_Model_BaseMapper {

	/**
	 * @return Application_Model_ImovelMapper
	 */
	public static function instanciar() {
		return new Application_Model_ImovelMapper('Imovel');
	}

	public static function findImage($idimovel, $destaque = false, $quantidade = '') {
		$imageMapper = Application_Model_ImagemMapper::instanciar();
		$aImage = $imageMapper->fetchAll('idimovel =' . $idimovel, 'nmfoto', ($destaque) ? 1 : $quantidade);
		$aRetorno = array();
		if (!count($aImage) > 0)
			return $aRetorno; 
		
		foreach ($aImage as $sImage) {
			$aRetorno[] = 'i'.$sImage->getIdimovel().'_'.$sImage->getNmfoto().'.jpg';			
		}
		return $aRetorno;
	}
}

