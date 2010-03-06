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
$GLOBALS['TL_LANG']['tl_pm']['tstamp']			= array('Datum', '');
$GLOBALS['TL_LANG']['tl_pm']['sender']			= array('Absender', '');
$GLOBALS['TL_LANG']['tl_pm']['status']			= array('Status', '');
$GLOBALS['TL_LANG']['tl_pm']['recipient']		= array('Empfänger', '');
$GLOBALS['TL_LANG']['tl_pm']['subject']			= array('Betreff', '');
$GLOBALS['TL_LANG']['tl_pm']['message']			= array('Nachricht', '');
$GLOBALS['TL_LANG']['tl_pm']['messageRead']		= array('Nachricht wurde gelesen', 'Diese Checkbox ist aktiv, wenn der Empfänger die Nachricht gelesen hat.');
$GLOBALS['TL_LANG']['tl_pm']['senderDeleted']	= array('Nachricht vom Absender gelöscht', 'Diese Checkbox ist aktiv, wenn der Sender die Nachricht gelöscht hat.');
$GLOBALS['TL_LANG']['tl_pm']['recipientDeleted'] = array('Nachricht vom Empfänger gelöscht', 'Diese Checkbox ist aktiv, wenn der Empfänger die Nachricht gelöscht hat.');


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_pm']['new']         	= array('Neue Nachricht', 'Eine neue Nachricht erstellen');
$GLOBALS['TL_LANG']['tl_pm']['edit']        	= array('Nachricht bearbeiten', 'Nachricht ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_pm']['copy']        	= array('Nachricht duplizieren', 'Nachricht ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_pm']['delete']      	= array('Nachricht löschen', 'Nachricht ID %s löschen');
$GLOBALS['TL_LANG']['tl_pm']['show']        	= array('Nachrichtdetails', 'Details der Nachricht ID %s anzeigen');


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_pm']['send']			= 'Senden';
$GLOBALS['TL_LANG']['tl_pm']['reply']			= 'Antworten';
$GLOBALS['TL_LANG']['tl_pm']['delete']			= 'Löschen';
$GLOBALS['TL_LANG']['tl_pm']['status_options']	= array('ungelesen', 'gelesen', 'beantwortet');

