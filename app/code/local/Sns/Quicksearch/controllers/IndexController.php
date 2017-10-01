<?php

class Sns_Quicksearch_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function ajaxAction() {
		//Zend_Debug::dump(Mage::app()->getRequest()->getParams());
		//echo"test";die;
		$layout = Mage::getSingleton('core/layout');
		$block = $layout->createBlock('quicksearch/list');
		
		header('content-type: text/javascript');
		
		echo '{"htm":' . json_encode($block->toHtml()) .'}';
		//echo $block->toHtml();
		die();			
		$this->renderLayout();
    }
}
