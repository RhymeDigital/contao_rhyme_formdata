<?php

/**
 * Copyright (C) 2021 Rhyme Digital
 *
 * @link		https://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Table tl_form_submission
 */
$GLOBALS['TL_DCA']['tl_form_submission'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_form',
		'closed'                      => true,
		'notEditable'                 => true,
		'notCopyable'				  => true,
		'doNotCopyRecords'			  => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// List
	'list'  => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('tstamp DESC', 'id DESC'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('tstamp', 'id'),
			'format'                  => '<span style="color:#b3b3b3;padding-right:3px">[%s]</span> Submission # %s',
			'maxCharacters'           => 96,
		),
		'global_operations' => array
		(
			'exportCSV' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_form_submission']['exportCSV'],
				'href'                => 'key=exportCSV',
				'icon'                => 'system/modules/rhyme_formdata/assets/img/icon-csv-016.png',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'exportExcel' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_form_submission']['exportExcel'],
				'href'                => 'key=exportExcel',
				'icon'                => 'system/modules/rhyme_formdata/assets/img/icon-excel-016.png',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			),
		),
		'operations' => array
		(
			'submissions' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_form']['submissions'],
				'href'                => 'table=tl_form_submission_data',
				'icon'                => 'system/modules/rhyme_formdata/assets/img/icon-database-014.png'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_form_submission']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_form_submission']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL"
		),
		'tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_form_submission']['tstamp'],
			'sorting'                 => true,
			'flag'                    => 6,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
	)
);

