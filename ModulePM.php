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


abstract class ModulePM extends Module
{
	protected function generateRecipientNames()
	{
		$arrMembers = array();
		$arrFields = deserialize($this->pmFields);
		
		// Make sure we have fields
		if (!is_array($arrFields) || count($arrFields) == 0)
			$arrFields = array('username');
		
		$objMembers = $this->Database->execute("SELECT * FROM tl_member WHERE pmDisable=''");
		
		while( $objMembers->next() )
		{
			$arrValues = array();
			foreach( $arrFields as $field )
			{
				$arrValues[] = $objMembers->$field;
			}
			
			// Make sure we have a valid format string
			if (strpos($this->pmFormat, '%s') === false)
			{
				$this->pmFormat = '%s';
			}
			
			// Make sure sprintf has enough options
			$arrValues = array_merge($arrValues, array_fill(0, 100, ''));
						
			$arrMembers[$objMembers->id] = vsprintf($this->pmFormat, $arrValues);
		}

		asort($arrMembers);
		
		return $arrMembers;
	}
}

