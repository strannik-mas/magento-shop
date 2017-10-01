<?php

class Sns_Lamino_Model_System_Config_Source_BgRepeat
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'no-repeat', 'label'=>Mage::helper('lamino')->__('no-repeat')),
			array('value'=>'repeat', 'label'=>Mage::helper('lamino')->__('repeat')),
			array('value'=>'repeat-x', 'label'=>Mage::helper('lamino')->__('repeat-x')),
			array('value'=>'repeat-y', 'label'=>Mage::helper('lamino')->__('repeat-y'))
		);
	}
}
