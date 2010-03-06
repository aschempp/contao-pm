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
 * class ModulePMWriter
 * Write a private message
 */
class ModulePMWriter extends ModulePM
{
	/**
	 * Tempalte
	 */
	protected $strTemplate = 'mod_pm_writer';
	
	
	/**
	 * Display wildcard text in backend
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### PRIVATE MESSAGES WRITER ###';

			return $objTemplate->parse();
		}
		
		if (!FE_USER_LOGGED_IN)
			return '';
		
		$this->import('FrontendUser', 'User');
			
		$this->pmAllowNewGroups = deserialize($this->pmAllowNewGroups, true);
		$this->pmAllowReplyGroups = deserialize($this->pmAllowReplyGroups, true);
		
		// Show nothing if reply or new is not allowed
		if (($this->Input->get('reply') && count(array_intersect($this->User->groups, $this->pmAllowReplyGroups)) == 0)
		|| (!$this->Input->get('reply') && count(array_intersect($this->User->groups, $this->pmAllowNewGroups)) == 0))
		{
			return '';
		}
		
		return parent::generate();
	}
	
	
	/**
	 * Generate module
	 */
	protected function compile()
	{
		$blnReply = false;
		$arrPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")
								  ->limit(1)
								  ->execute($this->pmJumpToList)
								  ->fetchAssoc();
		
		$this->loadDataContainer('tl_pm');
		$this->loadLanguageFile('tl_pm');
		$this->Template->formId = 'tl_pm_send';
		$this->Template->action = $this->Environment->request;
		$this->Template->slabel = $GLOBALS['TL_LANG']['tl_pm']['send'];
		
		// Fetch member names for later use
		$arrMembers = $this->generateRecipientNames();
		
		if ($this->Input->get('reply'))
		{
			$objMessage = $this->Database->prepare("SELECT * FROM tl_pm WHERE tl_pm.id=?")
										 ->limit(1)
										 ->execute($this->Input->get('reply'));
									 
			if (!$objMessage->numRows)
			{
				$this->Template = new FrontendTemplate('mod_message');
				$this->Template->mclass = 'error';
				$this->Template->message = $GLOBALS['TL_LANG']['MSC']['pm_notfound'];
				return;
			}
			
			$blnReply = true;
		}
		
		
		// Apply module settings for recipient name
		$arrRecipients = $arrMembers;
		unset($arrRecipients[$this->User->id]);
		if (!$blnReply)
			$GLOBALS['TL_DCA']['tl_pm']['fields']['recipient']['inputType'] = $this->pmInput;
		$GLOBALS['TL_DCA']['tl_pm']['fields']['recipient']['options'] = $arrRecipients;
		unset($GLOBALS['TL_DCA']['tl_pm']['fields']['recipient']['foreignKey']);
		
		$i=0;
		$doNotSubmit = false;
		$arrFields = array('sender', 'recipient', 'subject', 'message');
		foreach( $arrFields as $field )
		{
			$arrData = $GLOBALS['TL_DCA']['tl_pm']['fields'][$field];
			$strClass = $GLOBALS['TL_FFL'][$arrData['inputType']];

			// Continue if the class is not defined
			if (!$this->classFileExists($strClass))
			{
				continue;
			}

			$objWidget = new $strClass($this->prepareForWidget($arrData, $field));

			$objWidget->rowClass = 'row_' . $i . (($i == 0) ? ' row_first' : '') . ((($i % 2) == 0) ? ' even' : ' odd');
			
			// Set specific values
			if ($field == 'sender')
			{
				$objWidget->value = $arrMembers[$this->User->id];
				$objWidget->style = '" readonly="readonly';
			}
			elseif ($field == 'recipient' && $blnReply)
			{
				$objWidget->options = array($arrMembers[$objMessage->sender]);
				$objWidget->value = $objMessage->sender;
				$objWidget->style = '" readonly="readonly';
			}
			elseif ($field == 'recipient' && strlen($this->Input->get('to')))
			{
				$objWidget->value = $this->Input->get('to');
			}
			elseif ($field == 'subject' && $blnReply)
			{
				$objWidget->value = sprintf($GLOBALS['TL_LANG']['MSC']['replySubject'], $objMessage->subject);
			}
			elseif ($field == 'message' && $blnReply)
			{
				$objWidget->value = sprintf($GLOBALS['TL_LANG']['MSC']['replyMessage'], $arrMembers[$objMessage->sender], date($GLOBALS['TL_CONFIG']['dateFormat'], $objMessage->tstamp),$objMessage->message);
			}

			// Validate input
			if ($this->Input->post('FORM_SUBMIT') == 'tl_pm_send' && $field != 'sender' && !($blnReply && $field == 'recipient'))
			{
				$objWidget->validate();
				$varValue = $objWidget->value;
				
				// Check: do not send to yourself
				if ($field == 'recipient' && $objWidget->value == $this->User->id)
				{
					$objWidget->addError($GLOBALS['TL_LANG']['ERR']['selfSend']);
				}

				if ($objWidget->hasErrors())
				{
					$doNotSubmit = true;
				}
			}

			$temp = $objWidget->parse();
			$this->Template->fields .= $temp;
			
			$i++;
		}
		
		if ($this->Input->post('FORM_SUBMIT') == 'tl_pm_send' && !$doNotSubmit)
		{
			$objRecipient = $this->Database->prepare("SELECT * FROM tl_member WHERE pmDisable='' AND id=?")
										   ->limit(1)
										   ->execute($this->Input->post('recipient'));
										   
			if (!$objRecipient->numRows)
			{
				$this->Template = new FrontendTemplate('mod_message');
				$this->Template->mclass = 'error';
				$this->Template->message = $GLOBALS['TL_LANG']['ERR']['invalidMember'];
				return;
			}
			
			if ($blnReply)
			{
				$this->Database->prepare("UPDATE tl_pm SET status=? WHERE id=?")
							   ->execute(2, $this->Input->get('reply'));
			}
										   
			$this->Database->prepare("INSERT INTO tl_pm (tstamp, sender, recipient, subject, message) VALUES (?, ?, ?, ?, ?)")
						   ->execute(time(), $this->User->id, $objRecipient->id, $this->Input->post('subject'), $this->Input->post('message'));
						   
			// Send notification e-mail
			if ($objRecipient->pmNotify)
			{
				$objEmail = new Email();
				$objEmail->from = $GLOBALS['TL_ADMIN_EMAIL'];
				$objEmail->subject = sprintf($GLOBALS['TL_LANG']['MSC']['pmSubject'], $this->Environment->host);
				$objEmail->text = sprintf($GLOBALS['TL_LANG']['MSC']['pmMessage'], $GLOBALS['TL_CONFIG']['websiteTitle'], $arrMembers[$this->User->id], $this->Input->post('subject'), $this->Environment->host);
				$objEmail->sendTo($objRecipient->email);

			}
						   
			$this->Template = new FrontendTemplate('mod_message');
			$this->Template->mclass = 'success';
			$this->Template->message = sprintf($GLOBALS['TL_LANG']['MSC']['pm_sent'], $this->Input->post('subject'), $arrMembers[$this->Input->post('recipient')]);
			return;
		}
	}
}

