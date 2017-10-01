<?php
	
class Sns_Lamino_Model_System_Config_Source_ListCmsPage {
    protected $_options;
    
    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = Mage::getResourceModel('cms/page_collection')
                ->load()->toOptionIdArray();
            $options = array();
            foreach($this->_options as $option){
            	$option['label'] = $option['label'] . ' - ' . $option['value'];
            	$options[] = $option;
            }
            $this->_options = $options;
        }
        return $this->_options;
    }
}
