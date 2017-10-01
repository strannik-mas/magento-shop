<?php

class Sns_Lamino_Model_System_Config_Source_ListColor
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'red', 'label'=>Mage::helper('lamino')->__('Red')),
			array('value'=>'brown', 'label'=>Mage::helper('lamino')->__('Brown')),
			array('value'=>'purple', 'label'=>Mage::helper('lamino')->__('Purple')),
			array('value'=>'yellow', 'label'=>Mage::helper('lamino')->__('Yellow')),
			array('value'=>'blue', 'label'=>Mage::helper('lamino')->__('Blue')),
			array('value'=>'green', 'label'=>Mage::helper('lamino')->__('Green')),
			array('value'=>'chocolate', 'label'=>Mage::helper('lamino')->__('Chocolate')),
			array('value'=>'slateblue', 'label'=>Mage::helper('lamino')->__('Slateblue')),
		);
	}
}
