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

require_once(t3lib_extMgm::extPath('wow_guild').'inc/class.tx_wowguild_guild.php');

DEFINE(CLASSID_WA,1);
DEFINE(CLASSID_PA,2);
DEFINE(CLASSID_HU,3);
DEFINE(CLASSID_RO,4);
DEFINE(CLASSID_PR,5);
DEFINE(CLASSID_DK,6);
DEFINE(CLASSID_SH,7);
DEFINE(CLASSID_MA,8);
DEFINE(CLASSID_WL,9);
DEFINE(CLASSID_DR,11);

DEFINE(CLASS_NAMES,'Warrior|Paladin|Hunter|Rogue|Priest|Death Knight|Shaman|Mage|Warlock|-|Druid');
DEFINE(CLASS_COLOR,'#C79C6E|#F58CBA|#ABD473|#FFF569|#FFFFFF|#C41F3B|#2459FF|#69CCF0|#9482C9||#FF7D0A');

/**
 * Module 'wow_guild' Section 'Members' for the 'wow_guild' extension.
 *
 * @author	Jobe <jobe@jobesoft.de>
 * @package	TYPO3
 * @subpackage	tx_wowguild
 */
class tx_wowguild_mod2 {
	var $prefixId      = 'tx_wowguild_mod2';		// Same as class name
	var $scriptRelPath = 'mod2/class.tx_wowguild_mod2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'wow_guild';	// The extension key.
  var $conf          = null;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{
    $this->conf = $conf;
    $guild = new tx_wowguild_guild($this->conf['realm'],$this->conf['name']);
    $content .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
    foreach( $guild->members->character as $num => $char ){
      $content .= sprintf(
        "<tr class=\"class%02d\"><td><a href=\"http://armory.wow-europe.com/character-sheet.xml?%s\" target=\"armory.wow-europe.com\">%s</a></td><td>[%02d]%s</td><td>[%02d]%s</td><td>%s</td></tr>\n",
        $char['classId'],
        $char['url'],
        $char['name'],
        $char['raceId'],
        $char['race'],
        $char['classId'],
        $char['class'],
        $char['level']
      );
    }
    $content .= "</table>\n";
    return $content;
	}
  
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod2/class.tx_wowguild_mod2.php']) {
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod2/class.tx_wowguild_mod2.php']);
}
?>