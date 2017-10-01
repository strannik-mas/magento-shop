<?php

class Sns_Lamino_Model_System_Config_Source_BgPosition
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'left top', 'label'=>Mage::helper('lamino')->__('left top')),
			array('value'=>'left center', 'label'=>Mage::helper('lamino')->__('left center')),
			array('value'=>'left bottom', 'label'=>Mage::helper('lamino')->__('left bottom')),
			array('value'=>'right top', 'label'=>Mage::helper('lamino')->__('right top')),
			array('value'=>'right center', 'label'=>Mage::helper('lamino')->__('right center')),
			array('value'=>'right bottom', 'label'=>Mage::helper('lamino')->__('right bottom')),
			array('value'=>'center top', 'label'=>Mage::helper('lamino')->__('center top')),
			array('value'=>'center center', 'label'=>Mage::helper('lamino')->__('center center')),
			array('value'=>'center bottom', 'label'=>Mage::helper('lamino')->__('center bottom'))
		);
	}
}
