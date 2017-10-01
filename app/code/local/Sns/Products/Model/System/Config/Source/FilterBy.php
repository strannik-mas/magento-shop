<?php

class Sns_Products_Model_System_Config_Source_FilterBy
{
	public function toOptionArray()
	{
		return array(
			array('value' => 'all',	'label' => Mage::helper('products')->__('All Product')),
			array('value' => 'sale', 	'label' => Mage::helper('products')->__('Only Sale Product')),
			array('value' => 'deals', 	'label' => Mage::helper('products')->__('Hot Deals')),
			array('value' => 'featured', 	'label' => Mage::helper('products')->__('Only Featured Product'))
		);
	}
}
