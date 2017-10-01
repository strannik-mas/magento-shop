<?php
define('PHP_TAB', chr(9));
class Sns_Lamino_Adminhtml_ConfigController extends Mage_Adminhtml_Controller_Action{ 
    public function indexAction() {
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/sns_lamino_cfg/"));
    }
    public function configAction() {
		$this->createDefaultConfig();
		$this->createPages();
		$this->createBlocks();
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/sns_lamino_cfg/"));
    }
	public function preg_replace_nth($pattern, $replacement, $subject, $nth=1) {
	    return preg_replace_callback($pattern,
	        function($found) use (&$pattern, &$replacement, &$nth) {
	                $nth--;
	                if ($nth==0) return preg_replace($pattern, $replacement, reset($found) );
	                return reset($found);
	        }, $subject,$nth  );
	}
    public function createDefaultConfig() {

		$modSnsDir = Mage::getBaseDir() . '/app/code/local/Sns/';
		$listMod = $this->read_dir($modSnsDir, 'dir', false);

		$mess = '';
		$mess .= '<h2>Create default configure for modules</h2>';
		$mess .= '<ol>';

		foreach($listMod as $mod) {
			$systemxml = file_get_contents($modSnsDir . $mod . '/etc/system.xml');
			$configxml = file_get_contents($modSnsDir . $mod . '/etc/config.xml');
			
			$cfgSections = array();
			$sections = simplexml_load_string($systemxml);
			$sections = $sections->sections;
			
			foreach($sections->children() as $key => $section) {
				$cfgSections[] = $key;
				$pattern = '/<'.$key.'>(.*?)<\/'.$key.'>/si';
				$cfg = $this->getCfg($key, false);
				preg_match_all('/<'.$key.'>/', $configxml, $matches);
				if($cfg && $cfg != '') {
					$cfg = "\n\n" . $cfg . "\n\n";
					$replacement = '<'.$key.'>'.$cfg.'</'.$key.'>';
					$configxml = $this->preg_replace_nth($pattern, $replacement, $configxml, count($matches[0]));
					file_put_contents($modSnsDir . $mod . '/etc/config.xml', $configxml);
					$mess .= '<li><strong>Created default config for ' . $mod . ' - ' . $key . '</strong></li>';
				} else {
					$mess .= '<li>' . $mod . ' using old config - ' . $key . '</li>';
				}
			}
		}
		$mess .= '</ol>';
		Mage::getSingleton('adminhtml/session')->addSuccess($mess);
    }
    
	public function createBlocks() {
    	$pathEtc = Mage::getModuleDir('etc', 'Sns_Lamino');
    	$blockFile = $pathEtc.DS.'import'.DS.'blocks.xml';

		$blockCollection = Mage::getModel('cms/block')->getCollection()->addFieldToFilter('is_active', 1);
		
		$mess = '';
		$mess .= '<h2>Static Block</h2>';
		$mess .= '<ol>';
		
	    // create xml document 
	    $xmldoc = new DOMDocument(); 
	    $xmldoc->formatOutput = true; 
	     
	    // create root nodes 
	    $root = $xmldoc->createElement("root"); 
	    $xmldoc->appendChild( $root ); 
	    
	    $blocks = $xmldoc->createElement("blocks");
	    $root->appendChild( $blocks ); 
	    
	    // start block
	    foreach ($blockCollection as $cmsblock) :
	    	if (preg_match('/^lamino_/i', $cmsblock->getIdentifier())) :
	    	
	    		$mess .= '<li>';
	    		$mess .= '<code>' . $cmsblock->getIdentifier() . '</code>' . '   -   ' . $cmsblock->getTitle();
	    		$mess .= '</li>';
	    	
		    	$blockData = $cmsblock->getData();

			    $cms_block = $xmldoc->createElement("cms_block");
			    $title = $xmldoc->createElement("title"); 
			    $title->appendChild($xmldoc->createTextNode($cmsblock->getTitle())); 
			    $cms_block->appendChild( $title );

			    $identifier = $xmldoc->createElement("identifier"); 
			    $identifier->appendChild($xmldoc->createTextNode($cmsblock->getIdentifier())); 
			    $cms_block->appendChild( $identifier );
			    
			    $content = $xmldoc->createElement("content"); 
				$contentHTML = $xmldoc->createDocumentFragment();
				$contentHTML->appendXML('<![CDATA['.$blockData['content'].']]>');
				$content->appendChild($contentHTML);
			    $cms_block->appendChild( $content );
			    
			    $is_active = $xmldoc->createElement("is_active"); 
			    $is_active->appendChild($xmldoc->createTextNode($blockData['is_active'])); 
			    $cms_block->appendChild( $is_active );
				
			    $stores = $xmldoc->createElement("stores");
			    $item = $xmldoc->createElement("item");
			    $item->appendChild($xmldoc->createTextNode('0')); 
			    $stores->appendChild( $item );
			    $cms_block->appendChild( $stores );

			    $blocks->appendChild($cms_block);
		    endif;
		endforeach;
		
		$mess .= '</ol>';
		
	    $xmlData = $xmldoc->saveXML();
	    $xmlData = $this->xmlentities($xmlData);
	    @file_put_contents($blockFile, $xmlData);
	    
		Mage::getSingleton('adminhtml/session')->addSuccess($mess);
	}
	public function createPages() {
    	$pathEtc = Mage::getModuleDir('etc', 'Sns_Lamino');
    	$pageFile = $pathEtc.DS.'import'.DS.'pages.xml';

		$pageCollection = Mage::getModel('cms/page')->getCollection(); 
		$pageCollection->getSelect()->where('is_active = 1');
		
		
		$mess = '';
		$mess .= '<h2>CMS Page</h2>';
		$mess .= '<ol>';
		
	    // create xml document 
	    $xmldoc = new DOMDocument(); 
	    $xmldoc->formatOutput = true; 
	     
	    // create root nodes 
	    $root = $xmldoc->createElement("root"); 
	    $xmldoc->appendChild( $root ); 
	    
	    $pages = $xmldoc->createElement("pages");
	    $root->appendChild( $pages ); 
	    
	    // start page
	    foreach ($pageCollection as $cmspage) :
	    	if (preg_match('/^lamino_/i', $cmspage->getIdentifier())) :
		    	$pageData = $cmspage->getData();

	    		$mess .= '<li>';
	    		$mess .= '<code>' . $cmspage->getIdentifier() . '</code>' . '   -   ' . $cmspage->getTitle();
	    		$mess .= '</li>';

			    $cms_block = $xmldoc->createElement("cms_block");
			    $title = $xmldoc->createElement("title"); 
			    $title->appendChild($xmldoc->createTextNode($cmspage->getTitle())); 
			    $cms_block->appendChild( $title );

			    $identifier = $xmldoc->createElement("identifier"); 
			    $identifier->appendChild($xmldoc->createTextNode($cmspage->getIdentifier())); 
			    $cms_block->appendChild( $identifier );
			    
			    $content = $xmldoc->createElement("content"); 
				$contentHTML = $xmldoc->createDocumentFragment();
				$contentHTML->appendXML('<![CDATA['.$pageData['content'].']]>');
				$content->appendChild($contentHTML);
			    $cms_block->appendChild( $content );
			    
			    $is_active = $xmldoc->createElement("is_active"); 
			    $is_active->appendChild($xmldoc->createTextNode($pageData['is_active'])); 
			    $cms_block->appendChild( $is_active );
				
			    $stores = $xmldoc->createElement("stores");
			    $item = $xmldoc->createElement("item");
			    $item->appendChild($xmldoc->createTextNode('0')); 
			    $stores->appendChild( $item );
			    $cms_block->appendChild( $stores );
				
			    $root_template = $xmldoc->createElement("root_template"); 
			    $root_template->appendChild($xmldoc->createTextNode($pageData['root_template'])); 
			    $cms_block->appendChild( $root_template );

			    $layout_update_xml = $xmldoc->createElement("layout_update_xml"); 
				$layout_update_xmlHTML = $xmldoc->createDocumentFragment();
				$layout_update_xmlHTML->appendXML('<![CDATA['.$pageData['layout_update_xml'].']]>');
				$layout_update_xml->appendChild($layout_update_xmlHTML);
			    $cms_block->appendChild( $layout_update_xml );

			    $pages->appendChild($cms_block);
		    endif;
		endforeach;

		$mess .= '</ol>';

	    $xmlData = $xmldoc->saveXML();
	    $xmlData = $this->xmlentities($xmlData);
	    @file_put_contents($pageFile, $xmlData);
	    
	    Mage::getSingleton('adminhtml/session')->addSuccess($mess);
	}
	public function createConfig() {
		$this->removeConfig();
    	$pathEtc = Mage::getModuleDir('etc', 'Sns_Lamino');
		$xmlPath = $pathEtc.DS.'config.xml';
		$xmlObj = new Varien_Simplexml_Config($xmlPath);
		$section = Mage::getStoreConfig('sns_lamino_cfg');
		foreach($section as $group => $fields){
			foreach($fields as $field => $value){
				$xmlObj->setNode('default/sns_lamino_cfg/'.$group.'/'.$field, '<![CDATA['.$value.']]>');
			}
		}
		$xmlData = $xmlObj->getNode();
		//die(get_class($xmlData));
		if(is_writable($xmlPath)) {
			$xml_string = '<?xml version="1.0" ?>' . $this->get_text_of_element($xmlData);
		    @file_put_contents($xmlPath, $xml_string);
		}
	}
	function removeConfig () {
    	$pathEtc = Mage::getModuleDir('etc', 'Sns_Lamino');
		$xmlPath = $pathEtc.DS.'config.xml';
		$dom = new DOMDocument();
		$dom->load($xmlPath);
		$configs = $dom->getElementsByTagName('sns_lamino_cfg'); //translate
		foreach ($configs as $node){
			if(!$node->getAttribute('translate')){
				for($i = 0; $i < $node->childNodes->length; $i++) {
					$node->removeChild($node->childNodes->item($i));
				}
			}
		}
	    $xmlData = $dom->saveXML();
	    @file_put_contents($xmlPath, $xmlData);
	}
	function get_text_of_element($element, $level=0, $indent=PHP_TAB){
		$text = str_repeat($indent, $level) . '<' . $element->getName();
		foreach ($element->attributes() as $name => $value) {
			if ($value == 'safehtml' && $name=='filter'){
				$value = 'raw';
			}
			$text .= " $name=\"" . htmlentities($value) . "\"";
		}
		if ($element->count()){
			$text .= '>' . PHP_EOL;
			foreach ($element->children() as $subElement){
			$text .= $this->get_text_of_element($subElement, $level+1, $indent);
		}
			$text .= str_repeat($indent, $level) . '</' . $element->getName() . '>' . PHP_EOL;
		} else {
			$textContent = (string)$element;
			if (empty($textContent)){
				$text .= ' />' . PHP_EOL;
			} else {
				$text .= '>' . $textContent . '</' . $element->getName() . '>' . PHP_EOL;
			}
		}
		return $text;
	}
    public function xmlentities($value = null) {
        if (is_null($value)) {
            $value = $this;
        }
        $value = (string)$value;

        $value = str_replace(
        	array('<?xml version="1.0"?>'),
            array(''),
            $value
        );

        return $value;
    }
	    
	public function read_dir($dir,$type='both',$extra=false) {
	    $info=array();
	    $dh=opendir($dir);
	    $infod=array();$infof=array();
	        while ( $name = readdir( $dh ))
	        {
	            if( $name=="." || $name==".." ) continue;
	            if ( is_dir( "$dir/$name" ) && ( $type=='dir' || $type=='both') ){
	                if($extra) {
	                    $tinfo['name']=$name;
	                    $tinfo['path']=$dir.'/'.$name;
	                    $tinfo['size']='NA';
	                    $tinfo['created']=filectime("$dir/$name");
	                    $tinfo['type']='Folder';
	                    $infod[]=$tinfo;
	                } else $infod[]=$name; }
	       
	            if ( is_file( "$dir/$name" ) && ( $type=='file' || $type=='both')  ){
	                if($extra) {
	                    $tinfo['name']=$name;
	                    $tinfo['path']=$dir.'/'.$name;
	                    $tinfo['size']=filesize("$dir/$name");
	                    $tinfo['created']=filectime("$dir/$name");
	                    $tinfo['type']='File';
	                    $infof[]=$tinfo;
	                } else $infof[]=$name;
	            }
	        }
	    $info=array_merge($infod,$infof);
	    return $info;
	}
	public function getDb($note=false, $mageDir=false) {
		if(!$mageDir) $mageDir = Mage::getBaseDir();
		$configFile = file_get_contents($mageDir.'/app/etc/local.xml');
		$mage_db = simplexml_load_string($configFile);
		$mage_db = $mage_db->global->resources;
		if(!$note) {
			$db = array();
			$db['host'] = $mage_db->default_setup->connection->host;
			$db['username'] = $mage_db->default_setup->connection->username;
			$db['password'] = $mage_db->default_setup->connection->password;
			$db['dbname'] = $mage_db->default_setup->connection->dbname;
			$db['prefix'] = $mage_db->db->table_prefix;
			
			return $db;
		} else {
			if($note == 'table_prefix') return $mage_db->db->table_prefix;
			else return $mage_db->default_setup->connection->$note;
		}
	}

	public function getCfg($cfgPath, $del=false) {
		$cfgHTML = "";
		$db = $this->getDb();
		$con = mysqli_connect($db['host'], $db['username'], $db['password'], $db['dbname']);
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		} else {
			$query = 'SELECT * FROM `'.$db['prefix'].'core_config_data` WHERE scope_id=0 AND `'.$db['prefix'].'core_config_data`.`path` like "'.$cfgPath.'/%" ORDER BY `path`';
			$result = mysqli_query($con, $query);
			$groups = [];
			$fields = [];
			while($row = mysqli_fetch_array($result)) {
				$path = $row['path'];
				$pathArr = explode("/", $path);
				$groups[$pathArr[1]] = $pathArr[2];
				$fields[$path] = $row['value'];
			}
			foreach($groups as $k => $v){
				$cfgHTML .= '<' . $k . '>' . "\n";
					
					foreach($fields as $path => $value){
						$pathArr = explode("/", $path);
						$group = $pathArr[1];
						$field = $pathArr[2];
						if($k == $group){
							$cfgHTML .= "\t" . '<' . $field . '>';
							$cfgHTML .= '<![CDATA[';
							$cfgHTML .= htmlentities($value);
							$cfgHTML .= ']]>';
							$cfgHTML .= '</' . $field . '>' . "\n";
						}
					}
				$cfgHTML .= '</' . $k . '>' . "\n";
			}
			
			if($del) {
				$query = 'DELETE FROM `'.$db['prefix'].'core_config_data` WHERE scope_id=0 AND `'.$db['prefix'].'core_config_data`.`path` like "'.$cfgPath.'/%"';
				mysqli_query($con, $query);
			}
			
			mysqli_close($con);
		}
		return $cfgHTML;
	}
    
    
    
    
    
    
}
?>