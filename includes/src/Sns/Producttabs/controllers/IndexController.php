<?php
class Sns_Producttabs_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
	  $this->loadLayout();
      $this->renderLayout();
    }
	public function ajaxAction() {
		$layout   = Mage::getSingleton('core/layout');
		$block    = $layout->createBlock('producttabs/grid');
		echo '{"listProducts":' . json_encode($block->toHtml()) .'}';
		$this->renderLayout();
    }
	public function ajaxsliderAction() {
		$layout   = Mage::getSingleton('core/layout');
		$block    = $layout->createBlock('producttabs/slider')->setTemplate('sns/producttabs/items-slider.phtml');
		echo '{"listProducts":' . json_encode($block->toHtml()) .'}';
		$this->renderLayout();
    }
	public function ajaxgridAction() {
		$layout   = Mage::getSingleton('core/layout');
		$block    = $layout->createBlock('producttabs/grid');
		echo '{"listProducts":' . json_encode($block->toHtml()) .'}';
		$this->renderLayout();
    }
}