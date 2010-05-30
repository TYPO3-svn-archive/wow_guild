<?php

########################################################################
# Extension Manager/Repository config file for ext "wow_guild".
#
# Auto generated 30-05-2010 17:06
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'World of Warcraft - Guild',
	'description' => 'Manage your World of Warcraft Guild',
	'category' => 'World of Warcraft',
	'author' => 'Jobe',
	'author_email' => 'jobe@jobesoft.de',
	'shy' => '',
	'dependencies' => 'cms,wow_armory',
	'conflicts' => '',
	'priority' => '',
	'module' => 'mod1',
	'state' => 'experimental',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'typo3' => '4.3.2-0.0.0',
			'php' => '5.0-0.0.0',
			'wow_armory' => '0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:13:{s:12:"ext_icon.gif";s:4:"e52c";s:14:"ext_tables.php";s:4:"e198";s:27:"icon_tx_wowguild_guilds.gif";s:4:"475a";s:13:"locallang.xml";s:4:"45d5";s:13:"wow_guild.kpf";s:4:"3ed6";s:19:"doc/wizard_form.dat";s:4:"ecd9";s:20:"doc/wizard_form.html";s:4:"6440";s:14:"mod1/clear.gif";s:4:"cc11";s:13:"mod1/conf.php";s:4:"4ee7";s:14:"mod1/index.php";s:4:"5128";s:18:"mod1/locallang.xml";s:4:"d52c";s:19:"mod1/moduleicon.gif";s:4:"a19d";s:14:"mod1/style.css";s:4:"d1dd";}',
);

?>