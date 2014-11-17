<?php

class Zend_View_Helper_Messenger extends Zend_View_Helper_Abstract {

	/**
	 * FlashMessenger
	 *
	 * @var Zend_Controller_Action_Helper_FlashMessenger
	 */
	protected $_flashMessenger = null;

	public function messenger($key = 'success', $template = '<div class="message %s closeable"><p><strong>%s</strong></p></div>') {
		$flashMessenger = $this->_getFlashMessenger();
		
		//get messages from previous requests
		$messages = $flashMessenger->getMessages();
		
		//add any messages from this request
		if ($flashMessenger->hasCurrentMessages()) {
			$messages = array_merge($messages, $flashMessenger->getCurrentMessages());
			//we don't need to display them twice.
			$flashMessenger->clearCurrentMessages();
		}
		
		//initialise return string
		$output = '';
		
		//process messages
		foreach ($messages as $message) {
			if (is_array($message)) {
				list($key, $message) = each($message);
			}
			$output .= sprintf($template, $key, $message);
		}
		
		return $output;
	}

	/**
	 * Lazily fetches FlashMessenger Instance.
	 *
	 * @return Zend_Controller_Action_Helper_FlashMessenger
	 */
	public function _getFlashMessenger() {
		if (null === $this->_flashMessenger) {
			$this->_flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		}
		return $this->_flashMessenger;
	}
}