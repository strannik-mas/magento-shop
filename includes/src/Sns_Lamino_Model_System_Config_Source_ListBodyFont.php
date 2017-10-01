<?php
class Sns_Lamino_Model_System_Config_Source_ListBodyFont
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'arial', 'label'=>Mage::helper('lamino')->__('Arial')),
			array('value'=>'arial-black', 'label'=>Mage::helper('lamino')->__('Arial black')),
			array('value'=>'courier new', 'label'=>Mage::helper('lamino')->__('courier New')),
			array('value'=>'georgia', 'label'=>Mage::helper('lamino')->__('Georgia')),
			array('value'=>'impact', 'label'=>Mage::helper('lamino')->__('Impact')),
			array('value'=>'lucida-console', 'label'=>Mage::helper('lamino')->__('Lucida Console')),
			array('value'=>'lucida-grande', 'label'=>Mage::helper('lamino')->__('Lucida-grande')),
			array('value'=>'palatino', 'label'=>Mage::helper('lamino')->__('Palatino')),
			array('value'=>'tahoma', 'label'=>Mage::helper('lamino')->__('Tahoma')),
			array('value'=>'times new roman', 'label'=>Mage::helper('lamino')->__('Times')),
			array('value'=>'Trebuchet', 'label'=>Mage::helper('lamino')->__('Trebuchet')),
			array('value'=>'Verdana', 'label'=>Mage::helper('lamino')->__('Verdana')),
			array('value'=>'segoe ui', 'label'=>Mage::helper('lamino')->__('Segoe UI'))
		);
	}
}
