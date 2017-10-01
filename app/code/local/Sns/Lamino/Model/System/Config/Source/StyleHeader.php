<?php

class Sns_Lamino_Model_System_Config_Source_StyleHeader
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'transparent', 'label'=>Mage::helper('lamino')->__('Transparent')),
			array('value'=>'solid', 'label'=>Mage::helper('lamino')->__('Solid'))
		);
	}
}