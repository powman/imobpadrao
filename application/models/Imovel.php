<?php

class Application_Model_Imovel extends Application_Model_Base {

	protected $idimovel;

	protected $codigo_sistema;

	protected $descricao;

	protected $endereco;

	protected $tipo_imovel;

	protected $idtipo_imovel;

	protected $quarto;

	protected $suite;

	protected $sala_total;

	protected $venda_aluguel;

	protected $idsetor;

	protected $idcidade;

	protected $valor_venda;

	protected $valor_aluguel;

	protected $contador;

	protected $garagem_total;

	protected $area_util;

	protected $area_terreno;

	protected $valor_condominio;

	protected $destaque;

	protected $complemento;

	protected $estagio_obra;

	protected $info_estagio;

	protected $latitude;

	protected $longitude;

	protected $publicacao_exibir_valor;
	
	protected $categoria;

	/**
	 * @return the $idimovel
	 */
	public function getIdimovel() {
		return $this->idimovel;
	}

	/**
	 * @return the $codigo_sistema
	 */
	public function getCodigo_sistema() {
		return $this->codigo_sistema;
	}

	/**
	 * @return the $descricao
	 */
	public function getDescricao() {
		return $this->descricao;
	}

	/**
	 * @return the $endereco
	 */
	public function getEndereco() {
		return $this->endereco;
	}

	/**
	 * @return the $tipo_imovel
	 */
	public function getTipo_imovel() {
		return $this->tipo_imovel;
	}

	/**
	 * @return the $idtipo_imovel
	 */
	public function getIdtipo_imovel() {
		return $this->idtipo_imovel;
	}

	/**
	 * @return the $quarto
	 */
	public function getQuarto() {
		return $this->quarto;
	}

	/**
	 * @return the $suite
	 */
	public function getSuite() {
		return $this->suite;
	}

	/**
	 * @return the $sala_total
	 */
	public function getSala_total() {
		return $this->sala_total;
	}

	/**
	 * @return the $venda_aluguel
	 */
	public function getVenda_aluguel() {
		return $this->venda_aluguel;
	}

	/**
	 * @return the $idsetor
	 */
	public function getIdsetor() {
		return $this->idsetor;
	}

	/**
	 * @return the $idcidade
	 */
	public function getIdcidade() {
		return $this->idcidade;
	}

	/**
	 * @return the $valor_venda
	 */
	public function getValor_venda() {
		return $this->valor_venda;
	}

	/**
	 * @return the $valor_aluguel
	 */
	public function getValor_aluguel() {
		return $this->valor_aluguel;
	}

	/**
	 * @return the $contador
	 */
	public function getContador() {
		return $this->contador;
	}

	/**
	 * @return the $garagem_total
	 */
	public function getGaragem_total() {
		return $this->garagem_total;
	}

	/**
	 * @return the $area_util
	 */
	public function getArea_util() {
		return $this->area_util;
	}

	/**
	 * @return the $area_terreno
	 */
	public function getArea_terreno() {
		return $this->area_terreno;
	}

	/**
	 * @return the $valor_condominio
	 */
	public function getValor_condominio() {
		return $this->valor_condominio;
	}

	/**
	 * @return the $destaque
	 */
	public function getDestaque() {
		return $this->destaque;
	}

	/**
	 * @return the $complemento
	 */
	public function getComplemento() {
		return $this->complemento;
	}

	/**
	 * @return the $estagio_obra
	 */
	public function getEstagio_obra() {
		return $this->estagio_obra;
	}

	/**
	 * @return the $info_estagio
	 */
	public function getInfo_estagio() {
		return $this->info_estagio;
	}

	/**
	 * @return the $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * @return the $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * @return the $plublicacao_exibir_valor
	 */
	public function getPublicacao_exibir_valor() {
		return $this->publicacao_exibir_valor;
	}

	/**
	 * @return the $categoria
	 */
	public function getCategoria() {
		return $this->categoria;
	}

	/**
	 * @param field_type $idimovel
	 */
	public function setIdimovel($idimovel) {
		$this->idimovel = $idimovel;
	}

	/**
	 * @param field_type $codigo_sistema
	 */
	public function setCodigo_sistema($codigo_sistema) {
		$this->codigo_sistema = $codigo_sistema;
	}

	/**
	 * @param field_type $descricao
	 */
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}

	/**
	 * @param field_type $endereco
	 */
	public function setEndereco($endereco) {
		$this->endereco = $endereco;
	}

	/**
	 * @param field_type $tipo_imovel
	 */
	public function setTipo_imovel($tipo_imovel) {
		$this->tipo_imovel = $tipo_imovel;
	}

	/**
	 * @param field_type $idtipo_imovel
	 */
	public function setIdtipo_imovel($idtipo_imovel) {
		$this->idtipo_imovel = $idtipo_imovel;
	}

	/**
	 * @param field_type $quarto
	 */
	public function setQuarto($quarto) {
		$this->quarto = $quarto;
	}

	/**
	 * @param field_type $suite
	 */
	public function setSuite($suite) {
		$this->suite = $suite;
	}

	/**
	 * @param field_type $sala_total
	 */
	public function setSala_total($sala_total) {
		$this->sala_total = $sala_total;
	}

	/**
	 * @param field_type $venda_aluguel
	 */
	public function setVenda_aluguel($venda_aluguel) {
		$this->venda_aluguel = $venda_aluguel;
	}

	/**
	 * @param field_type $idsetor
	 */
	public function setIdsetor($idsetor) {
		$this->idsetor = $idsetor;
	}

	/**
	 * @param field_type $idcidade
	 */
	public function setIdcidade($idcidade) {
		$this->idcidade = $idcidade;
	}

	/**
	 * @param field_type $valor_venda
	 */
	public function setValor_venda($valor_venda) {
		$this->valor_venda = $valor_venda;
	}

	/**
	 * @param field_type $valor_aluguel
	 */
	public function setValor_aluguel($valor_aluguel) {
		$this->valor_aluguel = $valor_aluguel;
	}

	/**
	 * @param field_type $contador
	 */
	public function setContador($contador) {
		$this->contador = $contador;
	}

	/**
	 * @param field_type $garagem_total
	 */
	public function setGaragem_total($garagem_total) {
		$this->garagem_total = $garagem_total;
	}

	/**
	 * @param field_type $area_util
	 */
	public function setArea_util($area_util) {
		$this->area_util = $area_util;
	}

	/**
	 * @param field_type $area_terreno
	 */
	public function setArea_terreno($area_terreno) {
		$this->area_terreno = $area_terreno;
	}

	/**
	 * @param field_type $valor_condominio
	 */
	public function setValor_condominio($valor_condominio) {
		$this->valor_condominio = $valor_condominio;
	}

	/**
	 * @param field_type $destaque
	 */
	public function setDestaque($destaque) {
		$this->destaque = $destaque;
	}

	/**
	 * @param field_type $complemento
	 */
	public function setComplemento($complemento) {
		$this->complemento = $complemento;
	}

	/**
	 * @param field_type $estagio_obra
	 */
	public function setEstagio_obra($estagio_obra) {
		$this->estagio_obra = $estagio_obra;
	}

	/**
	 * @param field_type $info_estagio
	 */
	public function setInfo_estagio($info_estagio) {
		$this->info_estagio = $info_estagio;
	}

	/**
	 * @param field_type $latitude
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * @param field_type $longitude
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	/**
	 * @param field_type $plublicacao_exibir_valor
	 */
	public function setPublicacao_exibir_valor($publicacao_exibir_valor) {
		$this->publicacao_exibir_valor = $publicacao_exibir_valor;
	}

	/**
	 * @param field_type $categoria
	 */
	public function setCategoria($categoria) {
		$this->categoria = $categoria;
	}
	

	public function listarGrupo(){
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = $db->select()
		->from('imovel', array('categoria'))
		->group('categoria');
		$res = $db->fetchAll($sql);
		
		$retorno = array();
		if (is_array($res) && !empty($res)) {
			foreach ($res as $key => $value) {
				$retorno[$value['categoria']] = $value['categoria'];
			}
		}
		return $retorno;
	}

}
?>