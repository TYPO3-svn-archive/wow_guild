<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE')	{
		
	t3lib_extMgm::addModule('txwowguildM1','','top',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}

if (TYPO3_MODE == 'BE')  {
  t3lib_extMgm::addModule('txwowguildM1','','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');    
  t3lib_extMgm::addModule('txwowguildM1','txwowguildM2','bottom',t3lib_extMgm::extPath($_EXTKEY).'mod2/');
  t3lib_extMgm::addModule('txwowguildM1','txwowguildM3','bottom',t3lib_extMgm::extPath($_EXTKEY).'mod3/');
}

$TCA["tx_wowguild_guilds"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:wow_guild/locallang_db.xml:tx_wowguild_guilds',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_wowguild_guilds.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, fe_group, name",
	)
);
?>