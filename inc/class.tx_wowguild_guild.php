<?php /*require_once(t3lib_extMgm::extPath('wow_guild').'inc/class.tx_wowguild_guild.php');/*guild*/

DEFINE(TYPO3TEMP,PATH_site.'typo3temp/');
DEFINE(CACHETIME,2592000);/* = 30 days */

class tx_wowguild_guild{
    
    private $xml = null;

    public function tx_wowguild_guild($realm,$name,$lang='de-de'){
      if(!$this->load($realm,$name,$lang))
        if($this->query($realm,$name,$lang));
          $this->save();
    }
    
    private function query($realm,$name,$lang='de-de'){
      if(empty($realm))throw new Exception('noRealm');
      if(empty($name))throw new Exception('noName');
      libxml_use_internal_errors(false); libxml_clear_errors();
      libxml_set_streams_context(stream_context_create(array('http' => array(
        'user_agent' => sprintf('Mozilla/5.0 (Windows; U; Windows NT 5.1; %s; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6',$lang),
        'header' => sprintf('Accept-language: %s',$lang),
      ))));
      $url = sprintf('http://armory.wow-europe.com/guild-info.xml?r=%s&n=%s',$realm,$name);
      $this->xml = simplexml_load_file($url);
      return(!empty($this->xml));
    }
    
    private function load($realm,$name,$lang='de-de'){
      $cache = $this->cache($realm,$name,$lang);
      if(!file_exists($cache))return false;
      if( ( time() - filemtime($cache) ) > CACHETIME )return false;
      $this->xml = simplexml_load_file($cache);
      return(!empty($this->xml));
    }
    
    private function save(){
      $this->xml->asXML($this->cache($this->xml->guildKey['realm'],$this->xml->guildKey['name'],$this->xml['lang']));
    }
    
    private function cache($realm,$name,$lang){
      $lang = preg_replace('/([a-z]{2})[_-]([a-z]{2})/i','$1$2',strtolower($lang));
      return TYPO3TEMP.urlencode(strtolower(sprintf('wow_guild/%s-%s-%s.xml',$realm,$name,$lang)));
    }
    
    /* ACCESS */
    public function __get($key){
      switch($key){
        case 'members': return $this->getAll();
        case 'faction': return intval($this->xml->guildKey['factionId']);
        case 'name': return strval($this->xml->guildKey['name']);
        case 'realm': return strval($this->xml->guildKey['realm']);
      }
      return null;
    }
 
    public function getAll(){
      foreach( $this->xml->guildInfo->guild->members->character as $num => $char )$tmp[] = $char;
      return $tmp;
    }
 
    public function getByClass($classID){
      foreach( $this->xml->guildInfo->guild->members->character as $num => $char )if($char['classId']==$classID)$tmp[] = $char;
      return $tmp;
    }
    
    public function getByRace($raceID){
      foreach( $this->xml->guildInfo->guild->members->character as $num => $char )if($char['raceId']==$raceID)$tmp[] = $char;
      return $tmp;
    }

    public function isAlliance(){return ( $this->faction == 0 );}
    public function isHorde(){return ( $this->faction == 1 );}
    
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/class.tx_wowguild_guild.php']) {
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/wow_guild/class.tx_wowguild_guild.php']);
}
?>
