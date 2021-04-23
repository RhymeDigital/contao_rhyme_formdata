<?php

/**
 * Copyright (C) 2021 Rhyme Digital
 *
 * @link		https://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Rhyme\Hooks\ProcessFormData;

use Rhyme\Model\FormSubmissionModel;
use Rhyme\Model\FormSubmissionDataModel;


class StoreFormDataDynamically extends \Frontend
{
	
	/**
	 * Save the form data to tl_form_submission and tl_form_submission_data
	 * 
	 * Namespace:	Contao
	 * Class:		Form
	 * Method:		processFormData
	 * Hook:		$GLOBALS['TL_HOOKS']['processFormData']
	 *
	 * @access		public
	 * @param		array
	 * @param		array
	 * @param		array
	 * @param		array
	 * @param		object
	 * @return		void
	 */
	public function run($arrSubmitted, $arrData, $arrFiles=array(), $arrLabels=array(), $objForm=null)
	{
		if (!$arrData['storeDataDynamically'] || empty($arrSubmitted))
		{
			return;
		}
		
		$arrFiles = is_array($arrFiles) ? $arrFiles : array();
		
		$objParent				= new FormSubmissionModel();
		$objParent->pid			= $arrData['id'];
		$objParent->tstamp		= time();
		$objParent->save();
		
		foreach ($arrSubmitted as $k=>$v)
		{
			if (array_key_exists($k, $arrFiles))
			{
				continue;
			}
			
			$objData				= new FormSubmissionDataModel();
			$objData->pid			= $objParent->id;
			$objData->name			= $k;
			$objData->label			= strval($arrLabels[$k]);
			$objData->value			= serialize($v);
			$objData->save();
		}
		
		// Files
		if (!empty($arrFiles))
		{
			foreach ($arrFiles as $k=>$v)
			{
				if ($v['uploaded'])
				{
					$objData				= new FormSubmissionDataModel();
					$objData->pid			= $objParent->id;
					$objData->name			= $k;
					$objData->label			= strval($arrLabels[$k]);
					$objData->value			= serialize(str_replace(TL_ROOT . '/', '', $v['tmp_name']));
					$objData->save();
				}
			}
		}
	}
}
