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
 * class ModulePMList
 * Lists private messages (incoming + outgoing)
 */
class ModulePMList extends ModulePM
{
	/**
	 * Tempalte
	 */
	protected $strTemplate = 'mod_pm_list';
	
	
	/**
	 * Display wildcard text in backend
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### PRIVATE MESSAGES LIST ###';

			return $objTemplate->parse();
		}
		
		if (!FE_USER_LOGGED_IN)
			return '';
		
		$this->import('FrontendUser', 'User');
		
		return parent::generate();
	}
	
	
	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->loadLanguageFile('tl_pm');
		
		switch($this->pmFolder)
		{
			case 'in':
				$objMessages = $this->Database->prepare("SELECT * FROM tl_pm WHERE tl_pm.recipient=? AND recipientDeleted='' ORDER BY id DESC")->execute($this->User->id);
				break;
				
			case 'out':
				$objMessages = $this->Database->prepare("SELECT * FROM tl_pm WHERE tl_pm.sender=? AND senderDeleted='' ORDER BY id DESC")->execute($this->User->id);
				break;
		}
									  
		if (!$objMessages->numRows)
		{
			$this->Template = new FrontendTemplate('mod_message');
			$this->Template->mclass = 'empty';
			$this->Template->message = $GLOBALS['TL_LANG']['MSC']['pm_empty'];
			return;
		}
		
		// Fetch member names for later use
		$arrMembers = $this->generateRecipientNames();
		
		if ($this->Input->post('FORM_SUBMIT') == 'tl_pm_delete_all')
		{
			$arrIds = $this->Input->post('delete');
			
			if (is_array($arrIds))
			{
				foreach( $arrIds as $intId )
				{
					$this->deleteMessage($intId);
				}
			}
			
			$this->reload();
		}
		
		$arrPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")
								  ->execute($this->pmJumpToReader)
								  ->fetchAssoc();
		
		$arrMessages = array();
		while( $objMessages->next() )
		{
			$arrMessages[] = array
			(
				'id'			=> $objMessages->id,
				'sender'		=> $arrMembers[$objMessages->sender],
				'recipient'		=> $arrMembers[$objMessages->recipient],
				'subject'		=> $objMessages->subject,
				'date'			=> date($GLOBALS['TL_CONFIG']['dateFormat'], $objMessages->tstamp),
				'class'			=> ($objMessages->status == 1 ? 'read' : ($objMessages->status == 2 ? 'replied' : 'unread')),
				'href'			=> $this->generateFrontendUrl($arrPage, '/message/' . $objMessages->id),
				'status'		=> $GLOBALS['TL_LANG']['tl_pm']['status_options'][$objMessages->status],
			);
		}
		
		
		$this->Template->id 				= $this->id;
		$this->Template->messages			= $arrMessages;
		$this->Template->label_date			= $GLOBALS['TL_LANG']['tl_pm']['tstamp'][0];
		$this->Template->label_sender		= $GLOBALS['TL_LANG']['tl_pm']['sender'][0];
		$this->Template->label_recipient	= $GLOBALS['TL_LANG']['tl_pm']['recipient'][0];
		$this->Template->label_subject		= $GLOBALS['TL_LANG']['tl_pm']['subject'][0];
		$this->Template->label_delete		= $GLOBALS['TL_LANG']['tl_pm']['delete'];
		$this->Template->label_status		= $GLOBALS['TL_LANG']['tl_pm']['status'][0];
		$this->Template->action				= $this->Environment->request;
		
		$GLOBALS['TL_CSS'][] = 'plugins/tablesort/css/tablesort.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/tablesort/js/tablesort.js';
	}
	
	protected function deleteMessage($intId)
	{
		$objMessage = $this->Database->prepare("SELECT * FROM tl_pm WHERE id=?")
										 ->limit(1)
										 ->execute($intId);
										 
		if ($this->User->id == $objMessage->sender)
			$strField = 'senderDeleted';
		elseif ($this->User->id == $objMessage->recipient)
			$strField = 'recipientDeleted';
		else
			$this->log('Trying to delete a foreign message.', 'ModulePMList deleteMessage()', TL_ACCESS);
			
		$this->Database->prepare("UPDATE tl_pm SET " . $strField . "=1 WHERE id=?")
					   ->execute($intId);
	}
}

