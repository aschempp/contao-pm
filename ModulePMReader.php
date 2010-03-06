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
 * class ModulePMReader
 * Displays a private message
 */
class ModulePMReader extends ModulePM
{
	/**
	 * Tempalte
	 */
	protected $strTemplate = 'mod_pm_reader';
	
	
	/**
	 * Display wildcard text in backend
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### PRIVATE MESSAGES READER ###';

			return $objTemplate->parse();
		}
		
		$this->import('FrontendUser', 'User');
		
		if (!$this->User->id || !$this->Input->get('message'))
			return '';
		
		return parent::generate();
	}
	
	
	/**
	 * Generate module
	 */
	protected function compile()
	{
		$objMessage = $this->Database->prepare("SELECT * FROM tl_pm WHERE tl_pm.id=?")
									 ->limit(1)
									 ->execute($this->Input->get('message'));
									 
		if (!$objMessage->numRows)
		{
			$this->Template = new FrontendTemplate('mod_message');
			$this->Template->mclass = 'error';
			$this->Template->message = $GLOBALS['TL_LANG']['MSC']['pm_notfound'];
			return;
		}
		
		// Check that current user is sender or recipient
		if ($objMessage->sender != $this->User->id && $objMessage->recipient != $this->User->id)
		{
			$this->Template = new FrontendTemplate('mod_message');
			$this->Template->mclass = 'error';
			$this->Template->message = $GLOBALS['TL_LANG']['ERR']['foreignMessage'];
			return;
		}
		
		// Fetch member names for later use
		$arrMembers = $this->generateRecipientNames();									 
		
		// Update status if user is recipient
		if ($objMessage->recipient == $this->User->id)
		{
			$this->Database->prepare("UPDATE tl_pm SET status=? WHERE status=? AND id=?")
						   ->execute(1, 0, $this->Input->get('message'));
		}
		
		
		if ($this->Input->post('FORM_SUBMIT') == 'tl_pm_delete')
		{
			if ($this->User->id == $objMessage->sender)
				$strField = 'senderDeleted';
			elseif ($this->User->id == $objMessage->recipient)
				$strField = 'recipientDeleted';
			else
				throw new Exception('Trying to delete a foreign message.');
				
			$this->Database->prepare("UPDATE tl_pm SET " . $strField . "=? WHERE id=?")
						   ->execute(1, $this->Input->post('pm_id'));
						   
			$arrPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")
									  ->limit(1)
									  ->execute($this->pmJumpToList)
									  ->fetchAssoc();
									  
			$this->redirect($this->generateFrontendUrl($arrPage));
		}
		
		$arrPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")
								  ->limit(1)
								  ->execute($this->pmJumpToWriter)
								  ->fetchAssoc();
									 
		
		$this->loadLanguageFile('tl_pm');
		$this->Template->label_sender = $GLOBALS['TL_LANG']['tl_pm']['sender'][0];
		$this->Template->label_recipient = $GLOBALS['TL_LANG']['tl_pm']['recipient'][0];
		$this->Template->label_subject = $GLOBALS['TL_LANG']['tl_pm']['subject'][0];
		$this->Template->label_message = $GLOBALS['TL_LANG']['tl_pm']['message'][0];
		$this->Template->label_reply = $GLOBALS['TL_LANG']['tl_pm']['reply'];
		$this->Template->label_delete = $GLOBALS['TL_LANG']['tl_pm']['delete'];
		$this->Template->actionReply = $this->generateFrontendUrl($arrPage, '/reply/' . $this->Input->get('message'));
		$this->Template->actionDelete = $this->Environment->request;
		
		$this->Template->pm_id = $objMessage->id;
		$this->Template->sender = $arrMembers[$objMessage->sender];
		$this->Template->recipient = $arrMembers[$objMessage->recipient];
		$this->Template->subject = $objMessage->subject;
		$this->Template->message = nl2br($objMessage->message);
	}
}

