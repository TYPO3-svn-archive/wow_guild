<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Jobe <jobe@jobesoft.de>
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

/**
 * Module 'wow_guild' Section 'Raids' for the 'wow_guild' extension.
 *
 * @author	Jobe <jobe@jobesoft.de>
 * @package	TYPO3
 * @subpackage	tx_wowguild
 */
class tx_wowguild_mod3 {
	var $prefixId      = 'tx_wowguild_mod3';		// Same as class name
	var $scriptRelPath = 'mod3/class.tx_wowguild_mod3.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'wow_guild';	// The extension key.
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main()	{
    $content = '<table cellspacing="0" cellpadding="3" border="1">';
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_wowraid_raids','');
    $content .= sprintf("<tr><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr>",'instance','begin','prepare','participants');
    while( $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res) ){
      $content .= sprintf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>",$row['instance'],date('d.m.Y H:i:s',$row['begin']),$row['prepare'],$row['participants']);
    }
    $content .= '</table>';
		return $content;
	}
  
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod3/class.tx_wowguild_mod3.php']) {
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod3/class.tx_wowguild_mod3.php']);
}
?>