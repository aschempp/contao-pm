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
 * Table tl_pm 
 */
$GLOBALS['TL_DCA']['tl_pm'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'switchToEdit'                => false,
		'enableVersioning'            => false,
		'closed'					  => true,
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('subject'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('subject'),
			'format'                  => '%s',
			'label_callback'		  => array('tl_pm', 'labelCallback'),
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pm']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_pm']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => 'sender,recipient,tstamp;subject,message;status,senderDeleted,recipientDeleted'
	),

	// Fields
	'fields' => array
	(
		'tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pm']['tstamp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>10, 'rgxp'=>'date', 'style'=>'" disabled="disabled')
		),
		'sender' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pm']['sender'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true)
		),
		'recipient' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pm']['recipient'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'membertext',
			'foreignKey'			  => 'tl_member.username',
			'eval'                    => array('mandatory'=>true)
		),
		'subject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pm']['subject'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'message' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pm']['message'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>true)
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pm']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options'				  => array(0, 1, 2),
			'reference'				  => &$GLOBALS['TL_LANG']['tl_pm']['status_options'],
			'eval'					  => array(),
		),
		'senderDeleted' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pm']['senderDeleted'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'					  => array('style'=>'" disabled="disabled'),
		),
		'recipientDeleted' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_pm']['recipientDeleted'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'					  => array('style'=>'" disabled="disabled'),
		),
	)
);


class tl_pm extends Backend
{
	public function labelCallback($arrRow)
	{
		$objMessage = $this->Database->prepare("SELECT tl_pm.*, m1.username AS sender_name, m2.username AS recipient_name FROM tl_pm LEFT OUTER JOIN tl_member AS m1 ON tl_pm.sender=m1.id LEFT OUTER JOIN tl_member AS m2 ON tl_pm.recipient=m2.id WHERE tl_pm.id=?")
									 ->execute($arrRow['id']);
		
		return sprintf('%s <span style="color: #b3b3b3; padding-left: 3px">[%s -> %s]</span>',
			$arrRow['subject'],
			$objMessage->sender_name,
			$objMessage->recipient_name);
	}
}

