<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 1999-2004 Kasper Skaarhoj (kasper@typo3.com)
 *  (c) 2005-2006 Jan-Erik Revsbech <jer@moccompany.com>
 *  (c) 2006 Stanislas Rolland <stanislas.rolland(arobas)fructifor.ca>
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

unset($MCONF);
include ('conf.php');
include ($BACK_PATH.'init.php');
include ($BACK_PATH.'template.php');
$LANG->includeLLFile('EXT:wow_guild/mod1/locallang.xml');

/**
 * Class to producing navigation frame of the tx_directmail extension
 *
 * @author    Kasper Sk?rh?j <kasper@typo3.com>
 * @author    Ivan-Dharma Kartolo  <ivan.kartolo@dkd.de>
 *
 * @package   TYPO3
 * @subpackage   tx_directmail
 * @version   $Id: index.php 8299 2008-02-18 12:02:16Z ivankartolo $
 */

/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   62: class tx_directmail_navframe
 *   68:     function init()
 *  134:     function main()
 *  177:     function printContent()
 *
 * TOTAL FUNCTIONS: 3
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_directmail_navframe{
  /**
 * first initialization of the global variables. Set some JS-code
 *
 * @return  void    ...
 */
  function init()  {
    global $BE_USER,$LANG,$BACK_PATH,$TYPO3_CONF_VARS;

    $this->doc = t3lib_div::makeInstance('template');
    $this->doc->backPath = $BACK_PATH;


    $this->currentSubScript = t3lib_div::_GP('currentSubScript');

      // Setting highlight mode:
    $this->doHighlight = !$BE_USER->getTSConfigVal('options.pageTree.disableTitleHighlight');

    $this->doc->JScode='';

      // Setting JavaScript for menu.
    $this->doc->JScode=$this->doc->wrapScriptTags(
      ($this->currentSubScript?'top.currentSubScript=unescape("'.rawurlencode($this->currentSubScript).'");':'').'

      function jumpTo(params,linkObj,highLightID)  { //
        var theUrl = top.TS.PATH_typo3+top.currentSubScript+"?"+params;

        if (top.condensedMode)  {
          top.content.document.location=theUrl;
        } else {
          parent.list_frame.document.location=theUrl;
        }
        '.($this->doHighlight?'hilight_row("row"+top.fsMod.recentIds["txwowguildM1"],highLightID);':'').'
        '.(!$GLOBALS['CLIENT']['FORMSTYLE'] ? '' : 'if (linkObj) {linkObj.blur();}').'
        return false;
      }


        // Call this function, refresh_nav(), from another script in the backend if you want to refresh the navigation frame (eg. after having changed a page title or moved pages etc.)
        // See t3lib_BEfunc::getSetUpdateSignal()
      function refresh_nav() { //
        window.setTimeout("_refresh_nav();",0);
      }


      function _refresh_nav()  { //
        document.location="'.htmlspecialchars(t3lib_div::getIndpEnv('SCRIPT_NAME').'?unique='.time()).'";
      }

        // Highlighting rows in the page tree:
      function hilight_row(frameSetModule,highLightID) { //
          // Remove old:
        theObj = document.getElementById(top.fsMod.navFrameHighlightedID[frameSetModule]);
        if (theObj)  {
          theObj.style.backgroundColor="";
        }

          // Set new:
        top.fsMod.navFrameHighlightedID[frameSetModule] = highLightID;
        theObj = document.getElementById(highLightID);
        if (theObj)  {
          theObj.style.backgroundColor="'.t3lib_div::modifyHTMLColorAll($this->doc->bgColor,-5).'";
        }
      }
    ');
  }

  /**
   * Main function, rendering the browsable page tree
   *
   * @return  void    ...
   */
  function main()  {
    global $LANG,$BACK_PATH, $TYPO3_DB;

    $this->content = '';
    $this->content.= $this->doc->startPage('Navigation');

    $out = '';
    for( $i = 1 ; $i < 12 ; $i++ ) if( $label = $LANG->getLL(sprintf('class.%02d',$i)) ) $out .= $this->row($label,$i);
    $out = '<table cellspacing="0" cellpadding="0" border="0" width="100%">'.$out.'</table>';
    $this->content.= $this->doc->section($LANG->getLL('sortby.class'), $out, 1, 1, 0 , TRUE);
    $this->content.= $this->doc->spacer(10);/**/
    
    $out = '';
    for( $i = 1 ; $i < 12 ; $i++ ) if( $label = $LANG->getLL(sprintf('race.%02d',$i)) ) $out .= $this->row($label,$i);
    $out = '<table cellspacing="0" cellpadding="0" border="0" width="100%">'.$out.'</table>';
    $this->content.= $this->doc->section($LANG->getLL('sortby.race'), $out, 1, 1, 0 , TRUE);
    $this->content.= $this->doc->spacer(10);/**/
    
    /* refresh
    $this->content.='<p class="c-refresh"><a href="'.htmlspecialchars(t3lib_div::linkThisScript(array('unique' => uniqid('directmail_navframe')))).'">';
    $this->content.='<img'.t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/refresh_n.gif','width="14" height="14"').' title="'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.refresh',1).'" alt="" />';
    $this->content.='REFRESH</a></p><br />';/**/

    // Adding highlight - JavaScript
    if($this->doHighlight)$this->content.=$this->doc->wrapScriptTags('hilight_row("",top.fsMod.navFrameHighlightedID["web"]);');
    
  }

  private function row($label,$uid){
    $out .= "<tr onmouseover=\"this.style.backgroundColor='".t3lib_div::modifyHTMLColorAll($this->doc->bgColor,-5)."'\" onmouseout=\"this.style.backgroundColor=''\">";
    $out .= "<td id=\"dmail_".$uid."\"><a href=\"#\" onclick=\"top.fsMod.recentIds['txwowguildM1']=".$uid.";jumpTo('id=".$uid."',this,'dmail_".$uid."');\">&nbsp;&nbsp;";
    $out .= htmlspecialchars($label);
    $out .= '</a></td></tr>';
    return $out;
  }
  
  /**
   * Outputting the accumulated content to screen
   *
   * @return  void
   */
  function printContent()  {
    $this->content.= $this->doc->endPage();
    echo $this->content;
  }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod1/index.php'])  {
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/mod1/index.php']);
}

// Make instance:

$GLOBALS['SOBE'] = t3lib_div::makeInstance('tx_directmail_navframe');
$SOBE->init();
$SOBE->main();
$SOBE->printContent();

?>
