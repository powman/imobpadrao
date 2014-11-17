<?php

class Application_Model_Plugin {

	private $idPluginRef;

	/**
	 * @return the $idPluginRef
	 */
	public function getIdPluginRef() {
		return $this->idPluginRef;
	}

	/**
	 * @param $idPluginRef the $idPluginRef to set
	 */
	public function setIdPluginRef($idPluginRef) {
		$this->idPluginRef = $idPluginRef;
	}

	public function __construct(array $options = null) {
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}

	public function setOptions(array $options) {
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}

}
?>