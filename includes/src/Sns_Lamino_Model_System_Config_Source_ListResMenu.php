<?php

class Sns_Lamino_Model_System_Config_Source_ListResMenu
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'sidebar', 'label'=>Mage::helper('lamino')->__('SideBar')),
			array('value'=>'collapse', 'label'=>Mage::helper('lamino')->__('Collapse'))
		);
	}
}
