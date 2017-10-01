<?php

class Sns_Slideshow_Helper_Data extends Mage_Core_Helper_Abstract {
	public function __construct(){
		$this->defaults = array(
		);
	}

	function get($attributes=array()) {
		$data = $this->defaults;
		$general 					= Mage::getStoreConfig("slideshow_cfg/general");
		
		if (!is_array($attributes)) {
			$attributes = array($attributes);
		}
		if (is_array($general))		$data = array_merge($data, $general);

		return array_merge($data, $attributes);;
	}
}
?>