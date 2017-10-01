<?php
class Sns_Lamino_Block_Adminhtml_Version extends Mage_Adminhtml_Block_System_Config_Form_Field {
	protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) { 
		$title = Mage::getConfig()->getNode()->modules->Sns_Lamino->title;
		$version = Mage::getConfig()->getNode()->modules->Sns_Lamino->version;
		return '<strong>'.$title.' v'.$version.'</strong>. If your version is older, please see changelog.txt file in the download package to update'; 
	} 
}
?>