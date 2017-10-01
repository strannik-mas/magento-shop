<?php
class Sns_Quicksearch_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function __construct(){
		$this->defaults = array();
	}

	function get($attributes=array())
	{
		$data = $this->defaults;
		$general 					= Mage::getStoreConfig("sns_quicksearch_cfg/general");
		if (!is_array($attributes)) {
			$attributes = array($attributes);
		}
		if (is_array($general))					$data = array_merge($data, $general);
		return array_merge($data, $attributes);;
	}

    public function getCategoryParamName() {
        return Mage::getModel('catalog/layer_filter_category')->getRequestVar();
    }

	public function getSuggestUrl()
	{
		return $this->_getUrl('quicksearch/suggest/result', array(
			'_secure' => Mage::app()->getFrontController()->getRequest()->isSecure()
		));
	}

}
