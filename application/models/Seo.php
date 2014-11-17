<?php

class Application_Model_Seo extends Application_Model_Base {

	protected $idSeo;

	protected $nmpagina;

	protected $metaTitle;

	protected $metaDescription;
	
	protected $metaKeywords;
	
	/**
	 * @return the $idSeo
	 */
	public function getIdSeo() {
		return $this->idSeo;
	}

	/**
	 * @return the $nmpagina
	 */
	public function getNmpagina() {
		return $this->nmpagina;
	}

	/**
	 * @return the $metaTitle
	 */
	public function getMetaTitle() {
		return $this->metaTitle;
	}

	/**
	 * @return the $metaDescription
	 */
	public function getMetaDescription() {
		return $this->metaDescription;
	}

	/**
	 * @return the $metaKeywords
	 */
	public function getMetaKeywords() {
		return $this->metaKeywords;
	}

	/**
	 * @param field_type $idSeo
	 */
	public function setIdSeo($idSeo) {
		$this->idSeo = $idSeo;
	}

	/**
	 * @param field_type $nmpagina
	 */
	public function setNmpagina($nmpagina) {
		$this->nmpagina = $nmpagina;
	}

	/**
	 * @param field_type $metaTitle
	 */
	public function setMetaTitle($metaTitle) {
		$this->metaTitle = $metaTitle;
	}

	/**
	 * @param field_type $metaDescription
	 */
	public function setMetaDescription($metaDescription) {
		$this->metaDescription = $metaDescription;
	}

	/**
	 * @param field_type $metaKeywords
	 */
	public function setMetaKeywords($metaKeywords) {
		$this->metaKeywords = $metaKeywords;
	}


	
}