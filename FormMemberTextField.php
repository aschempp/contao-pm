<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Form field "member textfield".
 * @copyright  Andreas Schempp 2009
 * @author     Andreas Schempp <andreas@schempp.ch>
 */
class FormMemberTextField extends Widget
{
	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'form_widget';
	
	/**
	 * Minimum characters to start autocomplete
	 * @var string
	 */
	protected $strCharacters = '1';
	
	/**
	 * Options (tokens)
	 * @var array
	 */
	protected $arrOptions = array();
	
	
	/**
	 * Initialize the object
	 * @param array
	 */
	public function __construct($arrAttributes=false)
	{
		$this->import('FrontendUser', 'User');
		
		return parent::__construct($arrAttributes);
	}
	
	
	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'value':
				$this->varValue = deserialize($varValue);
				break;

			case 'maxlength':
				$this->arrAttributes[$strKey] = ($varValue > 0) ? $varValue : '';
				break;

			case 'mandatory':
				$this->arrConfiguration['mandatory'] = $varValue ? true : false;
				break;
				
			case 'tags':
				$this->strTags = $varValue ? 'true' : 'false';
				break;
				
			case 'characters':
				$this->strCharacters = ($varValue > 0) ? $varValue : '1';
				break;
				
			case 'options':
				$arrValue = array();
				$arrOptions = deserialize($varValue);
				foreach ($arrOptions as $arrOption)
				{
					// Skip our own name
					if ($arrOption['value'] == $this->User->id)
						continue;
						
					$this->arrOptions[$arrOption['value']] = $arrOption['label'];
					if ($arrOption['default'])
					{
						$arrValue[] = $arrOption['value'];
					}
				}
				$this->varValue = $arrValue;
				break;

			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}


	/**
	 * Return a parameter
	 * @return string
	 * @throws Exception
	 */
	public function __get($strKey)
	{
		switch ($strKey)
		{
			case 'options':
				return $this->arrOptions;
				break;

			default:
				return parent::__get($strKey);
				break;
		}
	}
	

	/**
	 * Validate value
	 * @param mixed
	 * @return mixed
	 */
	public function validate()
	{
		$varValue = trim($this->getPost($this->strName));
							
		if (!isset($this->arrOptions[$varValue]))
		{
			$this->addError($GLOBALS['TL_LANG']['ERR']['invalidMember']);
		}
		
		$this->varValue = $varValue;
	}
	
	
	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		// Inject autocompleter javascript
		if (version_compare(VERSION, '2.7', '<'))
		{
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/pm/html/2.6/Observer.js';
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/pm/html/2.6/Autocompleter.js';
			$GLOBALS['TL_CSS'][] = 'system/modules/pm/html/2.6/Autocompleter.css';
		}
		else
		{
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/pm/html/Observer.js';
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/pm/html/Autocompleter.js';
			$GLOBALS['TL_CSS'][] = 'system/modules/pm/html/Autocompleter.css';
		}
		
		// Generate javascript code
		$strTokens = 'var ctrl_' . $this->strId . '_tokens = Array();';
		foreach( $this->arrOptions as $k => $v )
		{
			$strTokens .= sprintf("\n	ctrl_%s_tokens[%s] = '%s'", $this->strId, $k, $v);
		}
		
		
		$strAutocompleter = "<script type=\"text/javascript\">
window.addEvent('domready', function() {

	%s

	new Autocompleter.Local('ctrl_%s', ctrl_%s_tokens, {
		'minLength': %s,
		onSelect: function(el) {
			$(el.id+'_post').value = eval(el.id+'_tokens').indexOf(el.value);
		}
	});
});
</script>";
		
		if (!$this->multiple)
		{
			return sprintf('<input type="text" id="ctrl_%s" class="text%s" value="%s"%s /><input type="hidden" name="%s" id="ctrl_%s_post" value="%s" />%s',
							$this->strId,
							(strlen($this->strClass) ? ' ' . $this->strClass : ''),
							specialchars($this->arrOptions[$this->varValue]),
							$this->getAttributes(),
							$this->strName,
							$this->strId,
							specialchars($this->varValue),
							sprintf($strAutocompleter,
									$strTokens,
									$this->strId,
									$this->strId,
									$this->strCharacters,
									$this->strName));
		}

		// Return if field size is missing
		if (!$this->size)
		{
			return '';
		}

		if (!is_array($this->varValue))
		{
			$this->varValue = array($this->varValue);
		}

		$arrFields = array();

		for ($i=0; $i<$this->size; $i++)
		{
			$arrFields[] = sprintf('<input type="text" name="%s[]" id="ctrl_%s" class="text_%s" value="%s"%s />%s',
									$this->strName,
									$this->strId.'_'.$i,
									$this->size,
									specialchars($this->varValue[$i]),
									$this->getAttributes(),
									sprintf($strAutocompleter,
									$strTokens,
									$this->strId.'_'.$i,
									$this->strId,
									$this->strCharacters));
									
			$strTokens = '';
		}

		return sprintf('<div id="ctrl_%s"%s>%s</div>',
						$this->strId,
						(strlen($this->strClass) ? ' class="' . $this->strClass . '"' : ''),
						implode(' ', $arrFields));
	}
}

