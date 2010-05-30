<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Markus Martens <markus@jobesoft.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


// DEFAULT initialization of a module [BEGIN]
unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH.'init.php');
require_once($BACK_PATH.'template.php');
$LANG->includeLLFile('EXT:wow_guild/mod1/locallang.xml');
require_once(PATH_t3lib.'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1); // This checks permissions and exits if the users has no permission for entry.
// DEFAULT initialization of a module [END]

/**
 * Module 'guild' for the 'wow_guild' extension.
 *
 * @author    Markus Martens <markus@jobesoft.de>
 * @package    TYPO3
 * @subpackage    tx_wowguild
 */
class  tx_wowguild_module1 extends t3lib_SCbase {

	var $pageinfo;
	var $guild = null;

	/**
	 * Initializes the Module
	 * @return    void
	 */
	function init()    {
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		parent::init();
	}

	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 * @return    void
	 */
	function menuConfig()    {
		global $LANG;
		$this->MOD_MENU = Array (
			'function' => Array (
				'1' => $LANG->getLL('page.1.title'),
				'2' => $LANG->getLL('page.2.title'),
				'3' => $LANG->getLL('page.3.title'),
			)
		);
		parent::menuConfig();
	}

	/**
	 * Main function of the module. Write the content to $this->content
	 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
	 *
	 * @return    [type]        ...
	 */
	function main()    {
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		// Access check! The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		$access = is_array($this->pageinfo) ? 1 : 0;
		if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id)){
			// Draw the header.
			$this->doc = t3lib_div::makeInstance('mediumDoc');
			$this->doc->backPath = $BACK_PATH;
			// styles
			$this->doc->styleSheetFile2 = $GLOBALS["temp_modPath"].'style.css';
			$this->doc->form='<form action="" method="POST">';
			// JavaScript
			$this->doc->JScode = '<script language="javascript" type="text/javascript">script_ended = 0;function jumpToUrl(URL){document.location = URL;}</script>';
			$this->doc->postCode='<script language="javascript" type="text/javascript">script_ended = 1;if (top.fsMod) top.fsMod.recentIds["web"] = 0;</script>';
			$headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br />'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'],50);
			$this->content.=$this->doc->startPage($LANG->getLL('title'));
			$this->content.=$this->doc->header($LANG->getLL('title'));
			$this->content.=$this->doc->spacer(5);
			$this->content.=$this->doc->section('',$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])));
			$this->content.=$this->doc->divider(5);
			// Render content:
			$this->moduleContent();
			// ShortCut
			if ($BE_USER->mayMakeShortcut())    {
				$this->content.=$this->doc->spacer(20).$this->doc->section('',$this->doc->makeShortcutIcon('id',implode(',',array_keys($this->MOD_MENU)),$this->MCONF['name']));
			}
			$this->content.=$this->doc->spacer(10);
		} else {
			// If no access or if ID == zero
			$this->doc = t3lib_div::makeInstance('mediumDoc');
			$this->doc->backPath = $BACK_PATH;
			$this->content.=$this->doc->startPage($LANG->getLL('title'));
			$this->content.=$this->doc->header($LANG->getLL('title'));
			$this->content.=$this->doc->spacer(5);
			$this->content.=$this->doc->spacer(10);
		}
		$this->content.=$this->doc->endPage();
		echo $this->content;
	}

	/**
	 * Generates the module content
	 * @return    void
	 */
	function moduleContent(){try{
		global $LANG;
		//t3lib_div::view_array($_GET)
		switch((string)$this->MOD_SETTINGS['function']){
			case 1: $this->content.=$this->doc->section($LANG->getLL('page.1.title'),'PAGE1',0,1); break;
			case 2: $this->content.=$this->doc->section($LANG->getLL('page.2.title'),'PAGE2',0,1); break;
			case 3: $this->content.=$this->doc->section($LANG->getLL('page.3.title'),'PAGE3',0,1); break;
		}
	}catch (Exception $e){
		$this->content.=$this->doc->section('ERROR:',"<pre>\n".$e->getMessage()."\n".$e->getTraceAsString()."</pre>\n",0,1);
	}}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod1/index.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod1/index.php']);
}

// Make instance:
$SOBE = t3lib_div::makeInstance('tx_wowguild_module1');
$SOBE->init();
foreach($SOBE->include_once as $INC_FILE) include_once($INC_FILE);// Include files?
$SOBE->main();

?>
