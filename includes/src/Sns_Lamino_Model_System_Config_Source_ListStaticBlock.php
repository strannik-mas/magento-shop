<?php

class Sns_Lamino_Model_System_Config_Source_ListStaticBlock {
    public function toOptionArray()
    {
		$staticBlocks = array();
		$staticBlocks[] = Mage::helper('adminhtml')->__('Please select static block ...');
		$cmsBlocksCollection = Mage::getModel('cms/block')->getCollection()->addFieldToFilter('is_active', 1);
		foreach($cmsBlocksCollection as $key => $cmsBlock){
			$staticBlocks[$cmsBlock->getIdentifier()] = htmlentities($cmsBlock->getTitle(), ENT_QUOTES) . ' - ' . $cmsBlock->getIdentifier();
		}
		return $staticBlocks;
    }
}
