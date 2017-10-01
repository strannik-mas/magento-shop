<?php
class Sns_Lamino_QuickviewController extends Mage_Core_Controller_Front_Action {		
    public function indexAction(){
	//	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$productId = (int) $this->getRequest()->getParam('id');

			// Prepare helper and params
			$viewHelper = Mage::helper('catalog/product_view');
		
			$params = new Varien_Object();
			$params->setCategoryId(false);
			$params->setSpecifyOptions(false);
		
			// Render page
			try {
				$viewHelper->prepareAndRender($productId, $this, $params);
			} catch (Exception $e) {
				if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
					if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
						$this->_redirect('');
					} elseif (!$this->getResponse()->isRedirect()) {
						$this->_forward('noRoute');
					}
				} else {
					Mage::logException($e);
					$this->_forward('noRoute');
				}
			}
//		} else {
//			$this->getResponse()->setRedirect(Mage::getBaseUrl());
//			return;
//		}

    }
}
?>
