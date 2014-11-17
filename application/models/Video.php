<?php

class Application_Model_Video extends Application_Model_Base {

	protected $idVideo;

	protected $idimovel;
	
	protected $titulo;

	protected $ativo;
	
	protected $video;
	
	
	
	/**
	 * @return the $titulo
	 */
	public function getTitulo() {
		return $this->titulo;
	}

	/**
	 * @param field_type $titulo
	 */
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}

	/**
	 * @return the $idVideo
	 */
	public function getIdVideo() {
		return $this->idVideo;
	}

	/**
	 * @return the $idimovel
	 */
	public function getIdimovel() {
		return $this->idimovel;
	}

	/**
	 * @return the $ativo
	 */
	public function getAtivo() {
		return $this->ativo;
	}

	/**
	 * @return the $video
	 */
	public function getVideo() {
		return $this->video;
	}

	/**
	 * @param field_type $idVideo
	 */
	public function setIdVideo($idVideo) {
		$this->idVideo = $idVideo;
	}

	/**
	 * @param field_type $idimovel
	 */
	public function setIdimovel($idimovel) {
		$this->idimovel = $idimovel;
	}

	/**
	 * @param field_type $ativo
	 */
	public function setAtivo($ativo) {
		$this->ativo = $ativo;
	}

	/**
	 * @param field_type $video
	 */
	public function setVideo($video) {
		$this->video = $video;
	}

	
	
	
}