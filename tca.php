<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_wowguild_guilds"] = array (
	"ctrl" => $TCA["tx_wowguild_guilds"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,fe_group,name"
	),
	"feInterface" => $TCA["tx_wowguild_guilds"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		"name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:wow_guild/locallang_db.xml:tx_wowguild_guilds.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, name")
	),
	"palettes" => array (
		"1" => array("showitem" => "fe_group")
	)
);
?>