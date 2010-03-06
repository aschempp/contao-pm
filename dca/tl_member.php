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
$GLOBALS['TL_DCA']['tl_member']['fields']['pmNotify'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_member']['pmNotify'],
	'default'       => '1',
	'inputType'		=> 'checkbox',
	'exclude'       => true,
	'eval'			=> array('feEditable'=>true, 'feGroup'=>'profile', 'tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_member']['fields']['pmDisable'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_member']['pmDisable'],
	'inputType'     => 'checkbox',
	'exclude'       => true,
	'eval'          => array('feEditable'=>true, 'feGroup'=>'profile', 'tl_class'=>'w50')
);


/**
 * Palettes
 */
if (version_compare(VERSION, '2.7', '<'))
{
	$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace('website;', 'website;pmNotify,pmDisable;', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);
}
else
{
	$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = preg_replace('@(publicFields;)@', 'publicFields,pmNotify,pmDisable;', $GLOBALS['TL_DCA']['tl_member']['palettes']['default'], -1, $intCount);
	
	if (!$intCount)
	{
		$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace('login;', 'login;{profile_legend:hide},pmNotify,pmDisable;', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);
	}
}

