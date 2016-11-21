<?php

/**
 * Copyright (C) 2015 Rhyme Digital
 * 
 * @author		Blair Winans <blair@rhyme.digital>
 * @author		Adam Fisher <adam@rhyme.digital>
 * @link		http://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Rhyme\Backend\FormSubmission;

use Rhyme\Model\FormSubmissionModel;
use Rhyme\Model\FormSubmissionDataModel;


class Export extends \Backend
{
	
	/**
	 * Export data
	 *
	 * @access		public
	 * @param		string
	 * @return		void
	 */
	public static function run($dc=null, $strName='formsubmissions', $blnHeaders=true)
	{
		if (!\Input::get('id')) return;
		
		$arrData = array();
		$arrFields = array();
		$arrLabels = array();
		$arrColumns = array('pid=?');
		$arrValues = array(\Input::get('id'));
		$arrOptions = array();
		
		// HOOK: add custom logic
		if (isset($GLOBALS['TL_HOOKS']['getFormSubmissionForExport']) && is_array($GLOBALS['TL_HOOKS']['getFormSubmissionForExport']))
		{
			foreach ($GLOBALS['TL_HOOKS']['getFormSubmissionForExport'] as $callback)
			{
				list($arrColumns, $arrValues, $arrOptions) = static::importStatic($callback[0])->$callback[1]($arrColumns, $arrValues, $arrOptions, get_called_class());
			}
		}
		
		if (!$arrOptions['order'])
		{
			$arrOptions['order'] = 'id DESC';
		}
		
		// Get submissions
		$objSubmissions = FormSubmissionModel::findBy($arrColumns, $arrValues, $arrOptions);
		
		if ($objSubmissions !== null)
		{
			// Get field names
			$objFields = \Database::getInstance()->prepare("SELECT name, label FROM ".FormSubmissionDataModel::getTable()." WHERE pid IN (".implode(',', $objSubmissions->fetchEach('id')).")")
												 ->execute();
			$objSubmissions->reset();
			$arrFields = array();
			$arrLabels = array();
			
			if ($objFields->numRows)
			{
				$arrFields = array_unique($objFields->fetchEach('name'));
				sort($arrFields);
				$objFields->reset();
			
				// Fill array keys with field names
				$arrLabels = array_fill_keys($arrFields, '');
				
				while ($objFields->next())
				{
					$arrLabels[$objFields->name] = $objFields->label;
				}
			}
			
			// Add date too
			$arrFields[] = 'rhyme_date';
			$arrLabels['rhyme_date'] = 'Date';
			
			while ($objSubmissions->next())
			{
				// Get submission data
				$objData = FormSubmissionDataModel::findBy(array('pid=?'), array($objSubmissions->current()->id));
				
				if ($objData !== null)
				{
					// Fill array keys with field names
					$arrRow = array_fill_keys($arrFields, '');
					
					while ($objData->next())
					{
						// Get value even if it's an array
						$varValue = unserialize($objData->current()->value);
						$varValue = $varValue === false ? $objData->current()->value : $varValue;
						
						if (is_array($varValue))
						{
							$varValue = implode(',', $varValue);
						}
						
						$arrRow[$objData->current()->name] = $varValue;
						$varValue = null;
					}
				
					// Add date too
					$arrRow['rhyme_date'] = date(\Config::get('datimFormat'), $objSubmissions->current()->tstamp);
					
					$arrData[] = $arrRow;
					$arrRow = array();
				}
			}
		}

		// HOOK: add custom logic
		if (isset($GLOBALS['TL_HOOKS']['exportFormSubmissionData']) && is_array($GLOBALS['TL_HOOKS']['exportFormSubmissionData']))
		{
			foreach ($GLOBALS['TL_HOOKS']['exportFormSubmissionData'] as $callback)
			{
				list($arrData, $arrFields, $arrLabels, $strName, $blnHeaders) = static::importStatic($callback[0])->$callback[1]($arrData, $arrFields, $arrLabels, $strName, $blnHeaders, get_called_class());
			}
		}
		
		// Auto set name
		if ($strName == 'formsubmissions')
		{
			$strName = 'form_' . \Input::get('id') . '_' . $strName;
		}
		
		// Add headers
		if ($blnHeaders && !empty($arrLabels))
		{
			array_insert($arrData, 0, array
			(
				$arrLabels
			));
		}
		
		static::export($arrData, $strName);
	}
	
}
