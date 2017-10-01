<?php

class Sns_Lamino_Model_System_Config_Source_ListEffectImage
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'', 'label'=>Mage::helper('lamino')->__('None')),
			array('value'=>'preserve-3d', 'label'=>Mage::helper('lamino')->__('Preserve 3D')),
			array('value'=>'translatex', 'label'=>Mage::helper('lamino')->__('Translate X')),
			array('value'=>'translatey', 'label'=>Mage::helper('lamino')->__('Translate Y')),
		);
	}
}
