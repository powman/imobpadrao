<?php

abstract class Application_Model_BaseMapper {

	protected $_dbTable;

	protected $_modelName;

	public $_name;

	protected function __construct($modelName) {
		$this->setDbTable('Application_Model_DbTable_' . $modelName);
		$this->_modelName = 'Application_Model_' . $modelName;
		$this->_name = $modelName;
	}

	public abstract static function instanciar();

	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalido Zend_Db_Table' . $this->_modelName);
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	public function getDbTable() {
		if (null === $this->_dbTable) {
			throw new Exception('Tabela não informada.', '500');
		}
		return $this->_dbTable;
	}

	public function save(Application_Model_Base $model) {
		$data = $model->toArray();
		$operador = Zend_Auth::getInstance()->getIdentity();
		$sGetFunc = 'getId' . $this->_name;
		if (!$model->$sGetFunc()) {
			$data['idUsuario_cadastro'] = $data['idUsuario_alteracao'] = $operador->idUsuario;
			$data['dhcadastro'] = $data['dhalteracao'] = date('Y-m-d h:i:s');
			return $this->getDbTable()->insert($data);
		} else {
			$data['idUsuario_alteracao'] = $operador->idUsuario;
			$data['dhalteracao'] = date('Y-m-d h:i:s');
			unset($data['idUsuario_cadastro']);
			unset($data['dhcadastro']);
			$this->getDbTable()->update($data, array('id' . $this->_name . ' = ?' => $model->$sGetFunc()));
			return $model->$sGetFunc();
		}
	}

	public function find($id, Application_Model_Base $model) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current()->toArray();
		$model->setOptions($row);
	}

	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset)->toArray();
		$entries = array();
		foreach ($resultSet as $row) {
			$entry = new $this->_modelName();
			$entry->setOptions($row);
			$entries[] = $entry;
		}
		return $entries;
	}
}

