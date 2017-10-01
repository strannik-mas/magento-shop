<?php

class Sns_Lamino_Model_System_Config_Source_ListMenuStyles
{
	public function toOptionArray()
	{
		return array(
			//array('value'=>'base', 'label'=>Mage::helper('lamino')->__('Base')),
			array('value'=>'mega', 'label'=>Mage::helper('lamino')->__('Mega'))
		);
	}
}
