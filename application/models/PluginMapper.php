<?php

class Application_Model_PluginMapper {

	protected $_dbTable;
	
	public static function instanciar() {
		return new Application_Model_PluginMapper('Plugin');
	}
	
	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	public function getDbTable() {
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_Plugin');
		}
		return $this->_dbTable;
	}

	public function save(Application_Model_Plugin $plugin) {
		$data = array('idPluginRef' => $plugin->getIdPluginRef());
		$this->getDbTable()->insert($data);
	}

	public function find($id, Application_Model_Plugin $plugin) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$aDados = $result->current()->toArray();
		$plugin->setOptions($aDados);
	}

	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset)->toArray();
		$entries = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Plugin();
			$entry->setOptions($row);
			$entries[] = $entry;
		}
		return $entries;
	}

	public function tratarRef($ident, $idRef, $idAlbum) {
		return $ident . str_padLeft($idRef, 3) . str_padLeft($idAlbum, 4);
	}
}

