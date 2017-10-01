<?php

class Sns_Lamino_Model_System_Config_Source_ListGoogleFont
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'', 'label'=>Mage::helper('lamino')->__('No select')),
			array('value'=>'Anton', 'label'=>Mage::helper('lamino')->__('Anton')),
			array('value'=>'Roboto+Condensed', 'label'=>Mage::helper('lamino')->__('Roboto Condensed')),
			array('value'=>'Port+Lligat+Slab', 'label'=>Mage::helper('lamino')->__('Port Lligat Slab')),
			array('value'=>'Questrial', 'label'=>Mage::helper('lamino')->__('Questrial')),
			array('value'=>'Kameron', 'label'=>Mage::helper('lamino')->__('Kameron')),
			array('value'=>'Oswald', 'label'=>Mage::helper('lamino')->__('Oswald')),
			array('value'=>'Open+Sans:300,400,600,700', 'label'=>Mage::helper('lamino')->__('Open Sans')),
			array('value'=>'Open+Sans+Condensed:300,300italic,700', 'label'=>Mage::helper('lamino')->__('Open Sans Condensed')),
			array('value'=>'BenchNine', 'label'=>Mage::helper('lamino')->__('BenchNine')),
			array('value'=>'Droid Sans', 'label'=>Mage::helper('lamino')->__('Droid Sans')),
			array('value'=>'Droid Serif', 'label'=>Mage::helper('lamino')->__('Droid Serif')),
			array('value'=>'PT Sans', 'label'=>Mage::helper('lamino')->__('PT Sans')),
			array('value'=>'Vollkorn', 'label'=>Mage::helper('lamino')->__('Vollkorn')),
			array('value'=>'Ubuntu', 'label'=>Mage::helper('lamino')->__('Ubuntu')),
			array('value'=>'Neucha', 'label'=>Mage::helper('lamino')->__('Neucha')),
			array('value'=>'Cuprum', 'label'=>Mage::helper('lamino')->__('Cuprum')),
			array('value'=>'Passion+One:400,700', 'label'=>Mage::helper('lamino')->__('Passion One')),
			array('value'=>'Roboto+Slab:400,700', 'label'=>Mage::helper('lamino')->__('Roboto Slab')),
			array('value'=>'Lobster+Two:400,700', 'label'=>Mage::helper('lamino')->__('Lobster Two')),
			array('value'=>'Alegreya:400,700', 'label'=>Mage::helper('lamino')->__('Alegreya'))
		);
	}
}
