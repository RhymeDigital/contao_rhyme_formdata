<?php

/**
 * Copyright (C) 2021 Rhyme Digital
 *
 * @link		https://rhyme.digital
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Table tl_form_submission_data
 */
$GLOBALS['TL_DCA']['tl_form_submission_data'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_form_submission',
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
			'fields'                  => array('pid'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('label', 'value'),
			'format'                  => '%s %s',
			'label_callback'		  => array('Rhyme\Backend\FormSubmissionData\ListCallbacks', 'labelCallback'),
		),
		'global_operations' => array
		(
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
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_form_submission_data']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_form_submission_data']['show'],
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
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_form_submission_data']['name'],
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'label' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_form_submission_data']['label'],
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'value' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_form_submission_data']['value'],
			'sql'                     => "blob NULL"
		),
	)
);

