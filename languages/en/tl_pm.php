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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_pm']['tstamp']			= array('Date', '');
$GLOBALS['TL_LANG']['tl_pm']['sender']			= array('Sender', '');
$GLOBALS['TL_LANG']['tl_pm']['status']			= array('Status', '');
$GLOBALS['TL_LANG']['tl_pm']['recipient']		= array('Recipient', '');
$GLOBALS['TL_LANG']['tl_pm']['subject']			= array('Subject', '');
$GLOBALS['TL_LANG']['tl_pm']['message']			= array('Message', '');
$GLOBALS['TL_LANG']['tl_pm']['messageRead']		= array('Message has been read', 'This checkbox will be enabled when the recipient has read the message.');
$GLOBALS['TL_LANG']['tl_pm']['senderDeleted']	= array('Sender deleted message', 'This checkbox will be enabled when the sender has deleted the message.');
$GLOBALS['TL_LANG']['tl_pm']['recipientDeleted'] = array('Recipient deleted message', 'This checkbox will be enabled when the recipient has deleted the message.');


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_pm']['new']         	= array('New message', 'Create a new private message');
$GLOBALS['TL_LANG']['tl_pm']['edit']        	= array('Edit message', 'Edit private message ID %s');
$GLOBALS['TL_LANG']['tl_pm']['copy']        	= array('Copy message', 'Copy private message ID %s');
$GLOBALS['TL_LANG']['tl_pm']['delete']      	= array('Delete message', 'Delete private message ID %s');
$GLOBALS['TL_LANG']['tl_pm']['show']        	= array('Message details', 'Show details of private message ID %s');


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_pm']['send']			= 'Send';
$GLOBALS['TL_LANG']['tl_pm']['reply']			= 'Reply';
$GLOBALS['TL_LANG']['tl_pm']['delete']			= 'Delete';
$GLOBALS['TL_LANG']['tl_pm']['status_options']	= array('unread', 'read', 'replied');


