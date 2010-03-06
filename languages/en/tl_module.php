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
$GLOBALS['TL_LANG']['tl_module']['pmShowEmpty']			= array('Show when no message', 'Show status "No new messages", otherwise nothing will be displayed.');
$GLOBALS['TL_LANG']['tl_module']['pmAllowNewGroups']	= array('Allow new messages for', 'Select the groups which are allowed to send new messages. If you select nothing, all groups are allowed.');
$GLOBALS['TL_LANG']['tl_module']['pmAllowReplyGroups']	= array('Allow reply messages for', 'Select the groups which are allowed to reply to messages. If you select nothing, all groups are allowed.');
$GLOBALS['TL_LANG']['tl_module']['pmJumpToReader']		= array('PM Reader Page', 'Select the page where the Message Reader is.');
$GLOBALS['TL_LANG']['tl_module']['pmJumpToWriter']		= array('PM Writer Page', 'Select the page where the Message Writer is.');
$GLOBALS['TL_LANG']['tl_module']['pmJumpToList']		= array('PM List Page', 'Select the page where the Message List (Inbox) is.');
$GLOBALS['TL_LANG']['tl_module']['pmFolder']			= array('PM Folder', 'Select the folder you want to list.');
$GLOBALS['TL_LANG']['tl_module']['pmInput']				= array('Input field for recipient', 'Select the type of field you want to use for recipients.');
$GLOBALS['TL_LANG']['tl_module']['pmFields']			= array('Fields for member name', 'Please select the fields you want to use in member names.');
$GLOBALS['TL_LANG']['tl_module']['pmFormat']			= array('Format for member name', 'Please enter the format for member names. Use %s as place holder for fields.');


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_module']['pmFolder_ref']['in']			= 'Inbox';
$GLOBALS['TL_LANG']['tl_module']['pmFolder_ref']['out']			= 'Outbox';
$GLOBALS['TL_LANG']['tl_module']['pmInput_ref']['membertext']	= 'Autocompleting Text Field';
$GLOBALS['TL_LANG']['tl_module']['pmInput_ref']['select']		= 'Select Menu';

