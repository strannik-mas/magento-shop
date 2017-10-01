<?php
//$themeCfg = Mage::helper('lamino/data')->get();
//$themeCfg->getField
class Sns_Lamino_Helper_Data extends Mage_Core_Helper_Abstract {
    public $data;
	public function __construct(){
		$this->defaults = array();
        $this->data = $this->get();
	}
	public function get($attributes=array()) {
		//Varien_Profiler::start('SNS Lamino');
		$this->data 						= $this->defaults;
		
		$config = array();
		
		foreach(Mage::getStoreConfig("sns_lamino_cfg") as $k => $group){
			$groupName = $k;
			foreach($group as $key => $value){
				$config[$groupName.'_'.$key] = $value;
			}
		}
		
		foreach(Mage::getStoreConfig("sns_lamino_sticky") as $k => $group){
			$groupName = $k;
			foreach($group as $key => $value){
				$config[$groupName.'_'.$key] = $value;
			}
		}

        if (is_array($config)) 				$this->data= array_merge($this->data, $config);
		if (!is_array($attributes))			$attributes = array($attributes);
		
		$cookies = Mage::getModel('core/cookie')->get();

		$tplName = Mage::getSingleton("core/design_package")->getPackageName() . '_' . Mage::getSingleton("core/design_package")->getTheme("frontend") . '_';
		
		if(!is_null(Mage::app()->getRequest()->getParam('sns_clearcookie'))){
			foreach($cookies as $key => $value) {
				if(preg_match("/$tplName/", $key)){
					Mage::getModel('core/cookie')->delete($key, Mage::getModel('core/cookie')->getPath());
				}
			}
		} else {
			if($this->data['advance_showCpanel'] == 1) {
				foreach($cookies as $key => $value) {
					$key = preg_replace("/$tplName/", '', $key);
					if($key == 'general_bodyBgImage'){
						$this->data['general_bodyBgImage2'] = '';
					}
					if(isset($this->data[$key])) {
						$this->data[$key] = $value;
					}
				}
			}
		}

        if(!is_null(Mage::app()->getRequest()->getParam('color_skin1'))) {
            $this->data['advance_themeColor'] = "#" . Mage::app()->getRequest()->getParam('color_skin1');
            Mage::getModel('core/cookie')->set($tplName.'advance_themeColor', $this->data['advance_themeColor']);
        }
        if(!is_null(Mage::app()->getRequest()->getParam('color_skin2'))) {
            $this->data['advance_themeColor2'] = "#" . Mage::app()->getRequest()->getParam('color_skin2');
            Mage::getModel('core/cookie')->set($tplName.'advance_themeColor2', $this->data['advance_themeColor2']);
        }
        
		//Varien_Profiler::stop('SNS Lamino');
		
		return array_merge($this->data, $attributes);;
	}
	public function getField($field) {
		if(isset($this->data[$field])) {
			return $this->data[$field];
		} else {
			return false;
		}
	}
	public function getImgRate() {
		return 1;
	}
	public function getImgSize($size) {
		$size = strtoupper($size);
		
		$imgRate = $this->getImgRate();
		$imgS_w = 80; // small img
		$imgS_h = 100; // small img
		$imgM_w = 100; // detail thumb img
		$imgM_h = 125; // detail thumb img
		$imgL_w = 260; // grid product img
		$imgLL_w = 240; // detail big img
		$imgLL_h = 300; // detail big img	
		$imgXL_w = 400; // detail big img
		$imgXL_h = 500; // detail big img		
		$imgXXL_w = 600;
		
		if($size == 'S') return array($imgS_w, $imgS_h / $imgRate);
		if($size == 'M') return array($imgM_w, $imgM_h / $imgRate);
		if($size == 'L') return array($imgL_w, $imgL_w / $imgRate);
		if($size == 'LL') return array($imgLL_w, $imgLL_h / $imgRate);
		if($size == 'XL') return array($imgXL_w, $imgXL_h / $imgRate);
		if($size == 'XXL') return array($imgXXL_w, $imgXXL_w / $imgRate);
		return;
		//	$imgSize = Mage::helper('lamino/data')->getImgSize(S);
		//	$imgSize[0], $imgSize[1]
	}

	public function getThemeCSS($attributes=array()) {
		$themeCssName = 'theme-' . str_replace("#", "", $this->getField('advance_themeColor')) . str_replace("#", "", $this->getField('advance_themeColor2'));
		return 'css/'.$themeCssName.'.css';
	}
	public function checkBrowser () {
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/chrome/i',$_SERVER['HTTP_USER_AGENT'])) return 'Chrome';
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/safari/i',$_SERVER['HTTP_USER_AGENT'])) return 'Safari';
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/opera/i',$_SERVER['HTTP_USER_AGENT'])) return 'OP';
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/msie/i',$_SERVER['HTTP_USER_AGENT'])) return 'IE';
	}
	public function getBrowser () {
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/chrome/i',$_SERVER['HTTP_USER_AGENT'])) return 'chrome';
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/safari/i',$_SERVER['HTTP_USER_AGENT'])) return 'safari';
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/opera/i',$_SERVER['HTTP_USER_AGENT'])) return 'op';
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/msie/i',$_SERVER['HTTP_USER_AGENT'])) {
			preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $reg); //Zend_Debug::dump($reg); die();
			if(!isset($reg[1])) {
				return 'ie';
			} else {
				return 'ie' . ' ie' . floatval($reg[1]);
			}
		}
	}
	
    public function getCfg($optionString) {
        return Mage::getStoreConfig('sns_lamino_cfg/' . $optionString);
    }
	public function delCacheCss ($directory, $minute) {
	    if ($directory != '.') {
	        $directory = rtrim($directory, '/') . '/';
	    }
	    if ($handle = opendir($directory)) {
	        while (false !== ($file = readdir($handle))) {
	            if ($file != '.' && $file != '..') {
					if(preg_match("/^theme-/i", $file) && preg_match("/css$/i", $file)) {
					    $filePath = $directory.$file;
					    $time_elapsed = (time() - filemtime($filePath)) / 60;
						if($time_elapsed > $minute){
							unlink($filePath);
						}
					}
	            }
	        }
	        closedir($handle);
	    }
	}
	public function cacheRefresh ($types = NULL) {
        $types = array('block_html');
        foreach ($types as $type) {
            $tags = Mage::app()->getCacheInstance()->cleanType($type);
            Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => $type));
        }
	}
	public function compileLess () {
		
		$skin_path = Mage::getDesign()->getSkinBaseDir();
		$skinDefaultPath = Mage::getDesign()->getSkinBaseDir(array('_theme' => 'default'));
		
		$themeColor = $this->getField('advance_themeColor');
		$themeColor2 = $this->getField('advance_themeColor2');
		
		$themeCssName = 'theme-' . str_replace("#", "", $themeColor) . str_replace("#", "", $themeColor2);
		$themeCssPath = $skin_path.'/css/'.$themeCssName.'.css';
		
		 
		$variables = (array(
			"color1" => $themeColor,
			"color2" => $themeColor2
		));
		$format = ($this->getField('advance_lessCompress')) ? 'compressed' : '';

		if($this->getField('advance_showCpanel')) {
		//	$this->delCacheCss($skin_path.'/css/', 10);
		}
		$lessPath = $skin_path . '/less/theme.less';
		if(!file_exists($lessPath)) {
			$lessPath = $skinDefaultPath . '/less/theme.less';
			$themeCssPath = $skinDefaultPath.'/css/'.$themeCssName.'.css';
		}
		if($this->getField('advance_lessEnabled') || !file_exists($themeCssPath)) {
			$this->_compileLess($lessPath, $themeCssPath, $variables, $format);
		}
	}
	public function _compileLess ($lessPath, $themeCssPath, $variables, $format) {
		$less = new lessc;
		$less->setVariables($variables);
		if($format) $less->setFormatter($format);
		$less->compileFile($lessPath, $themeCssPath);
	}
	public function getAttributeAdminLabel($attributeCode, $item){
	    ///trunk/app/code/core/Mage/Eav/Model/Config.php
	    $entityType = Mage::getModel('eav/config')->getEntityType('catalog_product');
	    //$entityTypeId = $entityType->getEntityTypeId();
	    $attributeModel = Mage::getModel('eav/entity_attribute')->loadByCode($entityType, $attributeCode);
	    $_collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
	                      ->setAttributeFilter($attributeModel->getId())
	                    ->setStoreFilter(0)
	                    ->load();
	 
	    foreach( $_collection->toOptionArray() as $_cur_option ) {
	        if ($_cur_option['value'] == $item->getValue()){ return $_cur_option['label']; }
	    }
	    return $item->getLabel();
	}
	public function getImgHtml($_content, $_width, $_height){
		preg_match_all("/\<img[^\>]*>/", $_content, $img);

		if(!preg_match("/\{{media [^\>]*}}/", $img[0][0], $mediaImgUrl) && $img[0][0] != '') {
			return $img[0][0];
		}
		
		if($img[0][0]){
			preg_match("/\{{media [^\>]*}}/", $img[0][0], $mediaImgUrl);
			$mediaImgUrl = preg_replace(array('/{{media url=/', '/}}/', '/"/', '/\'/'), array('', '', '', ''), $mediaImgUrl[0]);
			
			$imgName = explode("/", $mediaImgUrl);

			$_imgDir = Mage::getBaseDir('media');
			$_imgUrl = Mage::getBaseUrl('media');
			
			
			for($i = 0; $i < count($imgName) - 1; $i++){
				$_imgDir .= DS . $imgName[$i];
				$_imgUrl .= $imgName[$i] . '/';
			}
			$_imgDir .= DS;
			$_imgName = $imgName[count($imgName) - 1];
			
		} else {
			$_imgDir = Mage::getBaseDir('skin') . DS . 'frontend' . DS . 'default' . DS . 'default' . DS . 'images' . DS . 'catalog' . DS . 'product' . DS . 'placeholder' . DS;
			$_imgName = 'image.jpg';
		}
		
		$_cacheDir = Mage::getBaseDir('media') . DS . 'cache' . DS . 'blog' . DS;
		$_cacheUrl = Mage::getBaseUrl('media') . 'cache' . '/blog/';
			
		if (file_exists($_cacheDir . $_imgName)) {
		    return '<img src="'.$_cacheUrl . $_imgName.'" alt="" />';
		} elseif (file_exists($_imgDir . $_imgName)) {
		    if (!is_dir($_cacheDir)) {
		        mkdir($_cacheDir);
		    }
		    $_image = new Varien_Image($_imgDir . $_imgName);
		    $_image->constrainOnly(true);
		    $_image->keepAspectRatio(false);
		    $_image->keepFrame(true);
		    $_image->keepTransparency(true);
		    $_image->backgroundColor(array(255,255,255));
		    $_image->resize($_width, $_height);
		    $_image->save($_cacheDir . $_imgName);

		    return '<img src="'.$_cacheUrl . $_imgName.'" alt="" />';
		}
	}
	public function getImgUrl($_content){
		preg_match_all("/\<img[^\>]*>/", $_content, $img);
		
		if($img[0] && is_array($img[0])) {
			$imgTag = Mage::helper('cms')->getBlockTemplateProcessor()->filter($img[0][0]);
			$attrs = explode(" ", $imgTag);
			foreach($attrs as $attr) {
				if(preg_match('/^src="/i', $attr)) {
					$attrSrc = $attr;
				}
			}
			return $attrSrc;
		} else {
			return Mage::helper('cms')->getBlockTemplateProcessor()->filter('src="{{media url="wysiwyg/lamino/blog/no-image.jpg"}}"');
		}
	}
}















