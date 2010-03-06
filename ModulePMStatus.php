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
 * class ModulePMStatus
 * Displays new messages
 */
class ModulePMStatus extends ModulePM
{
	/**
	 * Tempalte
	 */
	protected $strTemplate = 'mod_pm_status';
	
	
	/**
	 * Display wildcard text in backend
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### PRIVATE MESSAGES STATUS ###';

			return $objTemplate->parse();
		}
		
		$this->import('FrontendUser', 'User');
		
		if (!$this->User->id)
			return '';
		
		return parent::generate();
	}
	
	
	/**
	 * Generate module
	 */
	protected function compile()
	{
		$objMessages = $this->Database->prepare("SELECT * FROM tl_pm WHERE recipient=? AND status=? AND recipientDeleted=''")
									  ->execute($this->User->id, 0);
									
		if ($objMessages->numRows)  
		{
			$arrPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")
									  ->limit(1)
									  ->execute($this->pmJumpToList)
									  ->fetchAssoc();
									  
			$this->Template->mclass = 'has-pm';
			
			if ($objMessages->numRows == 1)
			{
				$this->Template->message = '<a href="' . $this->generateFrontendURL($arrPage) . '">' . $GLOBALS['TL_LANG']['MSC']['has_pm'] . '</a>';
			}
			else
			{
				$this->Template->message = '<a href="' . $this->generateFrontendURL($arrPage) . '">' . sprintf($GLOBALS['TL_LANG']['MSC']['has_pms'], $objMessages->numRows) . '</a>';
			}
		}
		
		else
		{
			$this->Template->mclass = 'no-pm';
			$this->Template->message = $GLOBALS['TL_LANG']['MSC']['no_pm'];
		}
	}
}

