<?php

class Sns_Products_Model_System_Config_Source_ProductSources
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'catalog',	'label'=>Mage::helper('products')->__('Catalog')),
        	array('value'=>'product',	'label'=>Mage::helper('products')->__('Product'))
		);
	}
}
