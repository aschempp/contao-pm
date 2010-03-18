<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009-2010
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id$
 */


/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['has_pm']			= '1 new message';
$GLOBALS['TL_LANG']['MSC']['has_pms']			= '%s new messages';
$GLOBALS['TL_LANG']['MSC']['no_pm']				= 'No new messages';
$GLOBALS['TL_LANG']['MSC']['pm_empty']			= 'You have no messages in this folder.';
$GLOBALS['TL_LANG']['MSC']['pm_notfound']		= 'The message was not found.';
$GLOBALS['TL_LANG']['MSC']['pm_sent']			= 'Your message with subject "%s" has been sent to %s';
$GLOBALS['TL_LANG']['MSC']['pm_delete']			= 'Delete selected';
$GLOBALS['TL_LANG']['MSC']['replySubject']		= 'Re: %s';
$GLOBALS['TL_LANG']['MSC']['replyMessage']		= "\n\n\n-- %s wrote on the %s --\n\n%s";
$GLOBALS['TL_LANG']['MSC']['pmSubject']			= "New Message at %s";
$GLOBALS['TL_LANG']['MSC']['pmMessage']			= "This is an automated notificaton from \"%s\".\n\nYou have received a new message from %s with subject \"%s\".\n\n\nYou can disable this notification in your user profil on %s.";


/**
 * Errors
 */
$GLOBALS['TL_LANG']['ERR']['selfSend']			= 'You cannot send messages to yourself.';
$GLOBALS['TL_LANG']['ERR']['invalidMember']		= 'This member was not found or has disabled private messages.';
$GLOBALS['TL_LANG']['ERR']['foreignMessage']	= 'You cannot read a foreign message.';

