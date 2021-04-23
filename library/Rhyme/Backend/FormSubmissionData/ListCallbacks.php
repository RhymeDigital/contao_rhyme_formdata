<?php

/**
 * Copyright (C) 2021 Rhyme Digital
 *
 * @link		https://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Rhyme\Backend\FormSubmissionData;


class ListCallbacks extends \Backend
{
	
	/**
	 * Label callback for tl_form_submission_data
	 *
	 * @access		public
	 * @param		array
	 * @return		string
	 */
	public function labelCallback($arrRow)
	{
		$varValue = unserialize($arrRow['value']);
		$varValue = $varValue === false ? $arrRow['value'] : $varValue;
		
		if (is_array($varValue))
		{
			$varValue = implode(',', array_map('deserialize', $varValue));
		}
		
		return $arrRow['label'] . ': ' . $varValue;
	}
}
