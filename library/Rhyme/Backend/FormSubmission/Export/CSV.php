<?php

/**
 * Copyright (C) 2021 Rhyme Digital
 *
 * @link		https://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Rhyme\Backend\FormSubmission\Export;

use Rhyme\Backend\FormSubmission\Export;


class CSV extends Export
{

	/**
	 * Export data to CSV
	 *
	 * @access		public
	 * @param		array
	 * @param		string
	 * @return		void
	 */
	public static function export($arrData, $strName='formsubmissions')
	{
		// Make sure no output buffer is active
		// @see http://ch2.php.net/manual/en/function.fpassthru.php#74080
		while (@ob_end_clean());

		// Prevent session locking (see #2804)
		session_write_close();

		// Open the "save as É" dialogue
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: attachment; filename="' . $strName . '.csv"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Expires: 0');
		header('Connection: close');
		
		$fp = fopen('php://output', 'w');
		foreach ($arrData as $data) {
			fputcsv($fp, $data);
		}
		fclose($fp);
		
		exit;
					
	}
}
