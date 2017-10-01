<?php

class Sns_Facebook_Block_List extends Mage_Catalog_Block_Product_Abstract{
	protected $_config = null;
	protected $defaultTemplate = 'sns/facebook/default.phtml';

	public function __construct($attributes = array()){
		parent::__construct();
		$this->_config = Mage::helper('facebook/data')->get($attributes);
	}

	public function getConfig($name=null, $value=null){
		if (is_null($this->_config)){
			$this->_config = Mage::helper('facebook/data')->get(null);
		}
		if (!is_null($name) && !empty($name)){
			$valueRet = isset($this->_config[$name]) ? $this->_config[$name] : $value;
			return $valueRet;
		}
		return $this->_config;
	}

	public function setConfig($name, $value=null){
		if (is_null($this->_config)) $this->getConfig();
		if (is_array($name)){
			$this->_config = array_merge($this->_config, $name);
			return;
		}
		if (!empty($name)){
			$this->_config[$name] = $value;
		}
		return true;
	}

	protected function _toHtml(){
		if(!$this->_config['isenabled']) return;
		if ( !($template = $this->getTemplate()) ){
			$this->setTemplate($this->defaultTemplate);
		}
		return parent::_toHtml();
	}

	public function getConfigObject(){
		return (object)$this->getConfig();
	}

	public function getLikebox(){
		$option = $this->getConfigObject();
        if (!$option->isenabled)
            return false;
        $graph = (array)json_decode($this->file_get_contents_curl('http://graph.facebook.com/'.$option->fanpageName));
        if(empty($graph['id'])){
            return false;
        }
        $likebox = array();
        $likebox['info'] = $graph;
        $likebox['list'] = $this->getList($graph['id'], $option->numberDisplay);
        return $likebox;
	}

    public function file_get_contents_curl1($url) {
	    $ch = curl_init();
	    $useragent = "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:22.0) Gecko/20100101 Firefox/22.0"; //$_SERVER['HTTP_USER_AGENT']
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt ($ch, CURLOPT_USERAGENT, $useragent);
	    curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
	    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	    $data = curl_exec($ch);
	    curl_close($ch);

		return $data;
	}
	function file_get_contents_curl($url){ 
		$ch=curl_init(); 
		
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		
		$cont = curl_exec($ch); 
		
		if(curl_error($ch)) { 
			die(curl_error($ch)); 
		} 
		return $cont; 
	}
//	function file_get_contents_curl($url, $retries=5){
//		$ua = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';
//		if (extension_loaded('curl') === true){
//			$ch = curl_init();
//			 
//			curl_setopt($ch, CURLOPT_URL, $url); // The URL to fetch. This can also be set when initializing a session with curl_init().
//			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
//			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // The number of seconds to wait while trying to connect.
//			curl_setopt($ch, CURLOPT_USERAGENT, $ua); // The contents of the "User-Agent: " header to be used in a HTTP request.
//			curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); // To fail silently if the HTTP code returned is greater than or equal to 400.
//			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); // To follow any "Location: " header that the server sends as part of the HTTP header.
//			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); // To automatically set the Referer: field in requests where it follows a Location: redirect.
//			curl_setopt($ch, CURLOPT_TIMEOUT, 5); // The maximum number of seconds to allow cURL functions to execute.
//			curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // The maximum number of redirects
//			 
//			$result = trim(curl_exec($ch));
//			curl_close($ch);
//		}else{
//			$result = trim(file_get_contents($url));
//		}
//		 
//		if (empty($result) === true){
//			$result = false;
//			if ($retries >= 1){
//				sleep(1);
//				return file_get_contents_curl($url, $retries--);
//			}
//		}
//		return $result;
//	}

    public function pregString($attr, $string){
          preg_match('/'.$attr.'=["\']?([^"\' ]*)["\' ]/is', $string, $match);
          if($match){
            return urldecode($match[1]);
          }else {
            return false;
          }
    }
    public function getList($id, $number = 9){
        $htmlLB = $this->file_get_contents_curl('http://www.facebook.com/plugins/fan.php?connections='.$number.'&id='.$id);
        $doc = new DOMDocument('1.0', 'utf-8');
        @$doc->loadHTML($htmlLB);

        $fanList = array();
        $i = 0;
        foreach ($doc->getElementsByTagName('ul')->item(0)->childNodes as $node) {
            $raw = $doc->saveXML($node);
            $li = preg_replace("/<li[^>]+\>/i", "", $raw);
            $fanList[$i] = preg_replace("/<\/li>/i", "", $li);
            $i++;
        }
        $htmlList = '';
        foreach ($fanList as $key => $value) {
            $title = $this->pregString('title', $value);
            $shortTitle = $title;
            if (strlen($shortTitle) != strlen($title)) $shortTitle = $shortTitle."...";

            $image = $this->pregString('src', $value);
            $link = $this->pregString('href', $value);

            $htmlList .= '<div class="item">';
            if ($link != "") {
            $htmlList .= "<a class='item-face' href=\"".$link."\" title=\"".$title."\" target=\"_blank\"><img src=\"".$image."\" alt=\"\" /></a><span title=\"".$title."\" class='item-name'>".$shortTitle."</span>";
            }else{
            $htmlList .= "<span class='item-face' title=\"".$title."\"><img src=\"".$image."\" alt=\"\" /></span><span title=\"".$title."\" class='item-name'>".$shortTitle."</span>";
            }
            $htmlList .= '</div>';
        }
        return $htmlList;
    }
}
