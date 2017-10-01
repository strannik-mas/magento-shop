<?php

class Sns_Slideshow_Block_Slideshow extends Mage_Core_Block_Template
{
	protected $_tplDefault = 'sns/slideshow/default.phtml';
	protected $_config = null;
	protected $_storeId = null;
	protected $_cacheKeyArray = null;

    const CACHE_LIFETIME = 10000000;
    
	public function __construct($attributes = array()){
		parent::__construct();
		$this->_config = Mage::helper('slideshow/data')->get($attributes);
		$this->addData(array(
			'cache_tags'     => array(Mage_Catalog_Model_Product::CACHE_TAG),
            'cache_lifetime' => self::CACHE_LIFETIME,
		));
		
		$selfData = $this->getData();
		$configuration = $this->_getConfiguration();
		if ( count($configuration) ){
			foreach ($configuration as $field => $value) {
				$selfData[$field] = $value;
			}
		}
		if ( count($attributes) ){
			foreach ($attributes as $field => $value) {
				$selfData[$field] = $value;
			}
		}
		$this->setData($selfData);
	}
	
	public function getCacheKeyInfo() {
		if (NULL === $this->_cacheKeyArray) {
			$this->_cacheKeyArray = array(
				'SNS_SLIDESHOW_BLOCK_SLIDESHOW',
				Mage::app()->getStore()->getId(),
				'name' => $this->getNameInLayout(),
				(int)Mage::app()->getStore()->isCurrentlySecure(),
	            $this->getTemplateFile(),
	            'template' => $this->getTemplate()
			);
		}
		return $this->_cacheKeyArray;
	}
	protected function _getConfiguration($path = 'sns_slideshow_cfg'){
		$configuration = Mage::getStoreConfig($path);
		$conf_merged = array();
		foreach( $configuration as $group ){
			foreach($group as $field => $value){
				if (array_key_exists($field, $conf_merged)){
					
				} else {
					$conf_merged[$field] = $value;
				}
			}
		}
		return $conf_merged;
	}
	public function setConfig($key = null, $value = null){
		if ( is_array($key) ){
			foreach ($key as $k => $v){
				$this->setData($k, $v);
			}
		} else if ( !is_null($key) ) {
			$this->setData($key, $value);
		}
	}
	protected function _beforeToHtml(){
		if (!$this->getTemplate()) $this->setTemplate($this->_tplDefault);
		return parent::_toHtml();
	}

	public function getStoreId(){
		if (is_null($this->_storeId)){
			$this->_storeId = Mage::app()->getStore()->getId();
		}
		return $this->_storeId;
	}
	public function setStoreId($storeId=null){
		$this->_storeId = $storeId;
	}

	public function getConfigObject(){
		return $this->_config;
	}
}
