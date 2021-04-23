<?php

/**
 * Copyright (C) 2021 Rhyme Digital
 *
 * @link		https://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Rhyme\Backend\FormSubmission\Export;

use Rhyme\Backend\FormSubmission\Export;


class Excel extends Export
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
		if (!in_array('!composer', \ModuleLoader::getActive()))
		{
			\Message::addError($GLOBALS['TL_LANG']['ERR']['exportExcelNoComposer']);
			\System::redirect(str_ireplace('&key=exportExcel', '', \Environment::get('request')));
			return;
		}
		if (!is_file(TL_ROOT . '/composer/vendor/phpoffice/phpexcel/Classes/PHPExcel.php'))
		{
			\Message::addError($GLOBALS['TL_LANG']['ERR']['exportExcelNoPHPExcel']);
			\System::redirect(str_ireplace('&key=exportExcel', '', \Environment::get('request')));
			return;
		}
		
		parent::run($dc, $strName, $blnHeaders);
	}

	/**
	 * Export data to Excel
	 *
	 * @access		public
	 * @param		array
	 * @param		string
	 * @return		void
	 */
	public static function export($arrData, $strName='formsubmissions')
	{
		require_once(TL_ROOT . '/composer/vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
		
		// Create the PHPExcel object
		$objExcel = new \PHPExcel();
		
		// Set active sheet index to the first sheet
		$objExcel->setActiveSheetIndex(0);
		$objExcel->getActiveSheet()->fromArray($arrData);
						
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objExcel->setActiveSheetIndex(0);
		
		// Redirect output to a clientÕs web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $strName . '.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
		$objWriter->save('php://output');

		// Clean up
		unset($objExcel, $objExcelWriter);
		exit;		
	}
}
