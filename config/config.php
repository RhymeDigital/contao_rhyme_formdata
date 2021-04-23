<?php

/**
 * Copyright (C) 2021 Rhyme Digital
 *
 * @link		https://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['content']['form']['exportCSV'] 			= array('Rhyme\Backend\FormSubmission\Export\CSV', 'run');
$GLOBALS['BE_MOD']['content']['form']['exportExcel']		= array('Rhyme\Backend\FormSubmission\Export\Excel', 'run');


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['processFormData'][]					= array('Rhyme\Hooks\ProcessFormData\StoreFormDataDynamically', 'run');


/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['content']['form']['tables'][] = 'tl_form_submission';
$GLOBALS['BE_MOD']['content']['form']['tables'][] = 'tl_form_submission_data';


/**
 * Models
 */
$GLOBALS['TL_MODELS'][\Rhyme\Model\FormSubmissionModel::getTable()]				= 'Rhyme\Model\FormSubmissionModel';
$GLOBALS['TL_MODELS'][\Rhyme\Model\FormSubmissionDataModel::getTable()]			= 'Rhyme\Model\FormSubmissionDataModel';