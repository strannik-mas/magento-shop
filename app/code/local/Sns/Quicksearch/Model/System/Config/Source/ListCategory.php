<?php

class Sns_Quicksearch_Model_System_Config_Source_ListCategory
{
	public function toOptionArray($root_id, $level)
    {
        $options = array();
		$categories = array();
		$categories[] = $root_id;
        if ($level >= 2) {
			$category = Mage::getModel('catalog/category')->load($root_id);
			$subcategories = $category->getChildren();		
			foreach(explode(',',$subcategories) as $subcategory) {		
				if ($subcategory != '') {
					$categories[] = $subcategory;
				}
			}
			
			if ($level == 3) {
				foreach(explode(',',$subcategories) as $subcategory) {	
					$sub_category = Mage::getModel('catalog/category')->load($subcategory);
					$sub_subcategories = $sub_category->getChildren();
					foreach(explode(',',$sub_subcategories) as $sub_subcategory) {	
						if ($sub_subcategory != '') {
							$categories[] = $sub_subcategory;
						}
					}
				}
			}
		}
		
		$collection = Mage::getModel('catalog/category')
		->getCollection()
		->addFieldToFilter('parent_id', array('in'=> $categories))
		->addFieldToFilter('is_active', array('eq'=>'1'))
		->addAttributeToSelect('name');
	
		
        $cats = array();
     
        foreach ($collection as $category) {
			$c_level = $category->getLevel();			
			if ($category->getId() !=  $rootCatId && $c_level <= $level ) {
				$c = new stdClass();
				$c->label = $category->getName();
				$c->value = $category->getId();
				$c->level = $c_level - 1;
				$c->parentid = $category->getParentId();
				$cats[$c->value] = $c;
			}
        }

        foreach($cats as $id => $c){
        	if (isset($cats[$c->parentid])){
        		if (!isset($cats[$c->parentid]->child)){
        			$cats[$c->parentid]->child = array();
        		}
        		$cats[$c->parentid]->child[] =& $cats[$id];
        	}
        }
        foreach($cats as $id => $c){
        	if (!isset($cats[$c->parentid])){
        		$stack = array($cats[$id]);
        		while( count($stack)>0 ){
        			$opt = array_pop($stack);
        			$option = array(
		    			'label' => ($opt->level>1 ? str_repeat('- - ', $opt->level-1) : '') . $opt->label,
		    			'value' => $opt->value
		    		);
        			array_push($options, $option);
        			if (isset($opt->child) && count($opt->child)){
        				foreach(array_reverse($opt->child) as $child){
        					array_push($stack, $child);
        				}
        			}
        		}
        	}
        }
        unset($cats);
        return $options;
    }
}