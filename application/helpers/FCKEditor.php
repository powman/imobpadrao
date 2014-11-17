<?php
/** 
 * Abstract class for extension 
 */
require_once 'Zend/View/Helper/FormElement.php';

/** 
 * FCKeditor PHP class 
 */
require_once 'fckeditor/fckeditor.php';

/** 
 * Helper to generate a "textarea" element  * 
 * @category   Zend 
 * @package    Zend_View 
 * @subpackage Helper 
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)  * @license    http://framework.zend.com/license/new-bsd     New BSD License 
 */
class Zend_View_Helper_FCKEditor extends Zend_View_Helper_FormElement {

	/**      * Generates a richtext element using FCKeditor. 
	 * 
	 * @access public 
	 * 
	 * @param string|array $name If a string, the element name.  If an      * array, all other parameters are ignored, and the array elements 
	 * are extracted in place of added parameters. 
	 * 
	 * @param mixed $value The element value. 
	 * * @param array $attribs Attributes for the element tag. 
	 * 
	 * @return string The element XHTML. 
	 */
	public function FCKEditor($name = null, $value = null, $attribs = null) {
		if (is_null($name) && is_null($value) && is_null($attribs)) {
			return $this;
		}
		$info = $this->_getInfo($name, $value, $attribs);
		extract($info); // name, value, attribs, options, listsep, disable 
		

		$editor = new FCKeditor($name);
		// set variables uploaddir
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/FCKConfig.ini');
		$editor->BasePath = $config->FCK->BasePath;
		$editor->ToolbarSet = empty($attribs['ToolbarSet']) ? 'Basic' : $attribs['ToolbarSet'];
		$editor->Width = empty($attribs['Width']) ? '50%' : $attribs['Width'];
		$editor->Height = empty($attribs['Height']) ? 250 : $attribs['Height'];
		$editor->Value = $value;
		
		// set Config  
		$editor->Config['BaseHref'] = $editor->BasePath;
		$editor->Config['CustomConfigurationsPath'] = $editor->BasePath . 'editor/fckconfig.js';
		$editor->Config['SkinPath'] = $editor->BasePath . 'editor/skins/silver/';
		return $editor->createHtml();
	
	}
}