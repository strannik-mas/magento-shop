<?php
class Sns_Producttabs_Model_System_Config_Source_ProductOrderBy{
	public function toOptionArray(){
		return array(
// 			array('value' => 'random', 		'label' => Mage::helper('producttabs')->__('Random')),
			array('value' => 'position',	'label' => Mage::helper('producttabs')->__('Position')),
			array('value' => 'created_at', 	'label' => Mage::helper('producttabs')->__('Date Created')),
			array('value' => 'name', 		'label' => Mage::helper('producttabs')->__('Name')),
			array('value' => 'price', 		'label' => Mage::helper('producttabs')->__('Price')),
			array('value' => 'top_rating', 	'label' => Mage::helper('producttabs')->__('Top Rating')),
			array('value' => 'most_reviewed',	'label' => Mage::helper('producttabs')->__('Most Reviews')),
			array('value' => 'most_viewed',	'label' => Mage::helper('producttabs')->__('Most Visited')),
			array('value' => 'best_sales',	'label' => Mage::helper('producttabs')->__('Most Selling')),
			array('value' => 'is_featured',	'label' => Mage::helper('producttabs')->__('Is featured')),
		);
	}
}
