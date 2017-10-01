<?php


class Sns_Products_Model_System_Config_Source_OrderDirection
{
	public function toOptionArray()
	{
		return array(
			array('value' => 'asc',			'label' => Mage::helper('products')->__('Asc')),
			array('value' => 'desc', 		'label' => Mage::helper('products')->__('Desc'))
		);
	}
}
