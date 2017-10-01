<?php

class Sns_Lamino_Model_System_Config_Source_BgAttachment
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'fixed', 'label'=>Mage::helper('lamino')->__('fixed')),
			array('value'=>'scroll', 'label'=>Mage::helper('lamino')->__('scroll'))
		);
	}
}
