<?php

class Sns_Lamino_PagesController extends Mage_Core_Controller_Front_Action {
    public function IndexAction() {
	  $this->loadLayout();
      $this->renderLayout();
    }
    public function SalesAction() {
	  $this->loadLayout();
      $this->renderLayout();
    }
    public function NewsAction() {
	  $this->loadLayout();
      $this->renderLayout();
    }
    public function FeaturedAction() {
	  $this->loadLayout();
	  
	  //$this->getLayout()->getBlock('head')->setTitle($this->__('FeaturedAction'));
	  
      $this->renderLayout();
    }
}