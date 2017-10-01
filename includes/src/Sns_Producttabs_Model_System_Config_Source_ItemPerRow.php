<?php
class Sns_Producttabs_Model_System_Config_Source_ItemPerRow{
	public function toOptionArray(){
		return array(
			array('value' => '1',	'label' => Mage::helper('producttabs')->__('1')),
			array('value' => '2',	'label' => Mage::helper('producttabs')->__('2')),
			array('value' => '3',	'label' => Mage::helper('producttabs')->__('3')),
			array('value' => '4',	'label' => Mage::helper('producttabs')->__('4')),
			array('value' => '6',	'label' => Mage::helper('producttabs')->__('6'))
		);
	}
}
