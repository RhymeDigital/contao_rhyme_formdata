<?php

/**
 * Copyright (C) 2021 Rhyme Digital
 *
 * @link		https://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Config
 */
$GLOBALS['TL_DCA']['tl_form']['config']['ctable'][] = 'tl_form_submission';


/**
 * List
 */
$GLOBALS['TL_DCA']['tl_form']['list']['operations']['submissions'] = array
(
	'label'               => &$GLOBALS['TL_LANG']['tl_form']['submissions'],
	'href'                => 'table=tl_form_submission',
	'icon'                => 'system/modules/rhyme_formdata/assets/img/icon-database-014.png'
);


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_form']['palettes']['default'] = str_replace(',storeValues;', ',storeValues,storeDataDynamically;', $GLOBALS['TL_DCA']['tl_form']['palettes']['default']);


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form']['fields']['storeDataDynamically'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['storeDataDynamically'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'sql'                     => "char(1) NOT NULL default ''"
);

