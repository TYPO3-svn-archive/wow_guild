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

require_once(t3lib_extMgm::extPath('wow_guild').'inc/const.inc');
require_once(t3lib_extMgm::extPath('wow_guild').'inc/class.tx_wowguild_guild.php');

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
  var $modVars       = null;// url parameters
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{
    $this->conf = $conf;
    $this->modVars = array_merge($_GET,$_POST);// get parameters
    //$content .= t3lib_div::view_array($this->modVars).'<br />';
    if(empty($this->conf['realm']))return 'Please specify a realm!';
    if(empty($this->conf['name']))return 'Please specify a name!';
    $guild = new tx_wowguild_guild($this->conf['realm'],$this->conf['name']);
    $content .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
    
    if($this->modVars['race'])
      $characters = $guild->getByRace($this->modVars['race']);
    elseif($this->modVars['class'])
      $characters = $guild->getByClass($this->modVars['class']);
    else
      $characters = $guild->members;
    
    $tmp = array();
    foreach( $characters as $num => $char ){// sort by level
      if( $char['level'] > 79 ) $tmp['80'][] = $char;
      elseif( $char['level'] > 69 ) $tmp['70 - 79'][] = $char;
      elseif( $char['level'] > 59 ) $tmp['60 - 69'][] = $char;
      else $tmp['unter 60'][] = $char;
    }
    
    foreach( $tmp as $key => $characters ){
      $content .= "<tr><td colspan=\"6\">".$key."</td></tr>\n";
      foreach( $characters as $num => $char ){
        $content .= sprintf(
          "<tr class=\"class%02d\">".
          "<td><a href=\"http://armory.wow-europe.com/character-sheet.xml?%s\" target=\"armory.wow-europe.com\">%s</a></td>".
          "<td>%s</td><td>%s</td>".
          "<td>%s</td><td>%s</td>".
          "<td>%s</td>".
          "</tr>\n",
          $char['classId'],
          $char['url'],
          $char['name'],
          '<img src="'.sprintf(ARMORY_RACE_ICONS,$char['raceId'],$char['genderId']).'"/>',
          $char['race'],
          '<img src="'.sprintf(ARMORY_CLASS_ICONS,$char['classId']).'"/>',
          $char['class'],
          $char['level']
        );
      }
    }  
    $content .= "<tr><td colspan=\"6\" style=\"text-align:right;\">Anzahl: ".count($characters)."</td></tr>\n";
    $content .= "</table>\n";
    return $content;
	}
  
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod2/class.tx_wowguild_mod2.php']) {
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod2/class.tx_wowguild_mod2.php']);
}
?>