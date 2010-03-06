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


$GLOBALS['TL_DCA']['tl_module']['palettes']['pmstatus'] = '{title_legend},name,headline,type;{config_legend},pmShowEmpty;{redirect_legend},pmJumpToList;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['pmlist'] = '{title_legend},name,headline,type;{redirect_legend},pmJumpToReader,pmJumpToWriter;{config_legend},pmFolder,pmFields,pmFormat;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['pmreader'] = '{title_legend},name,headline,type;{redirect_legend},pmJumpToWriter,pmJumpToList;{config_legend},pmFields,pmFormat;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['pmwriter'] = '{title_legend},name,headline,type;{redirect_legend},pmJumpToList;{config_legend},pmInput,pmFields,pmFormat;{protected_legend:hide},pmAllowNewGroups,pmAllowReplyGroups,protected;{expert_legend},guests,cssID,space';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['pmShowEmpty'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['pmShowEmpty'],
	'inputType'				=> 'checkbox',
	'exclude'				=> true,
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pmAllowNewGroups'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['pmAllowNewGroups'],
	'inputType'				=> 'checkbox',
	'exclude'				=> true,
	'foreignKey'			=> 'tl_member_group.name',
	'eval'					=> array('multiple'=>true),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pmAllowReplyGroups'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['pmAllowReplyGroups'],
	'inputType'				=> 'checkbox',
	'exclude'				=> true,
	'foreignKey'			=> 'tl_member_group.name',
	'eval'					=> array('multiple'=>true),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pmJumpToReader'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['pmJumpToReader'],
	'inputType'				=> 'pageTree',
	'exclude'				=> true,
	'eval'					=> array('fieldType'=>'radio'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pmJumpToWriter'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['pmJumpToWriter'],
	'inputType'				=> 'pageTree',
	'exclude'				=> true,
	'eval'					=> array('fieldType'=>'radio'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pmJumpToList'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['pmJumpToList'],
	'inputType'				=> 'pageTree',
	'exclude'				=> true,
	'eval'					=> array('fieldType'=>'radio'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pmFolder'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['pmFolder'],
	'inputType'				=> 'radio',
	'exclude'				=> true,
	'options'				=> array('in', 'out'),
	'reference'				=> &$GLOBALS['TL_LANG']['tl_module']['pmFolder_ref'],
	'default'				=> 'in',
	'eval'					=> array('mandatory'=>true),
);
$GLOBALS['TL_DCA']['tl_module']['fields']['pmInput'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['pmInput'],
	'inputType'				=> 'select',
	'exclude'				=> true,
	'options'				=> array('membertext', 'select'),
	'reference'				=> &$GLOBALS['TL_LANG']['tl_module']['pmInput_ref'],
	'default'				=> 'membertext',
	'eval'					=> array('mandatory'=>true),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pmFields'] = array
(
	'label'              => &$GLOBALS['TL_LANG']['tl_module']['pmFields'],
	'exclude'            => true,
	'default'			 => array('username'),
	'inputType'          => 'checkboxWizard',
	'options_callback'   => array('tl_module_memberlist', 'getViewableMemberProperties'),
	'eval'               => array('multiple'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pmFormat'] = array
(
	'label'              => &$GLOBALS['TL_LANG']['tl_module']['pmFormat'],
	'exclude'            => true,
	'inputType'          => 'text',
	'default'			 => '%s',
	'eval'               => array('maxlength'=>255, 'decodeEntities'=>true)
);

