<?php

class Sns_Products_Model_System_Config_Source_OrderBy
{
	public function toOptionArray()
	{
		return array(
			array('value' => 'position',	'label' => Mage::helper('products')->__('Position')),
			array('value' => 'created_at', 	'label' => Mage::helper('products')->__('Date Created')),
			array('value' => 'name', 		'label' => Mage::helper('products')->__('Name')),
			array('value' => 'price', 		'label' => Mage::helper('products')->__('Price')),
			array('value' => 'random', 		'label' => Mage::helper('products')->__('Random')),
			array('value' => 'top_rating', 	'label' => Mage::helper('products')->__('Top Rating')),
			array('value' => 'most_reviewed',	'label' => Mage::helper('products')->__('Most Reviews')),
			array('value' => 'most_viewed',	'label' => Mage::helper('products')->__('Most Viewed')),
			array('value' => 'best_sales',	'label' => Mage::helper('products')->__('Most Selling')),
		);
	}
}
