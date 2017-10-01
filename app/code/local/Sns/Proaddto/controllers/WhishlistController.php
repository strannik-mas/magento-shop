<?php
class Sns_Proaddto_WhishlistController extends Mage_Core_Controller_Front_Action
{

	public function compareAction(){
        $store = Mage::app()->getStore();
        $code  = $store->getCode();
		$response = array();

		if ($productId = (int) $this->getRequest()->getParam('product')) {
			$product = Mage::getModel('catalog/product')
			->setStoreId(Mage::app()->getStore()->getId())
			->load($productId);

			if ($product->getId()) {
				Mage::getSingleton('catalog/product_compare_list')->addProduct($product);
				$response['status'] = 'SUCCESS';
				$message = '<span class="product-name">'.Mage::helper('core')->htmlEscape($product->getName()).'</span> '.$this->__('has been added to comparison list.');
				
                $response['message'] = $message;
				Mage::helper('catalog/product_compare')->calculate();
				Mage::dispatchEvent('catalog_product_compare_add_product', array('product'=>$product));
                $this->loadLayout();
                $sidebar_block = $this->getLayout()->getBlock('catalog.compare.sidebar');
                $sidebar = '';
                if($sidebar_block && !Mage::getStoreConfig("kallyas_settings/sidebar/compare_products", $code)){
                    $sidebar = $sidebar_block->toHtml();
                }
                $response['sidebar'] = $sidebar;
                $response['formKey'] = Mage::helper('core/url')->getEncodedUrl();
			}
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
		return;
	}

	protected function _getWishlist()
	{
		$wishlist = Mage::registry('wishlist');
		if ($wishlist) {
			return $wishlist;
		}

		try {
			$wishlist = Mage::getModel('wishlist/wishlist')
			->loadByCustomer(Mage::getSingleton('customer/session')->getCustomer(), true);
			Mage::register('wishlist', $wishlist);
		} catch (Mage_Core_Exception $e) {
			Mage::getSingleton('wishlist/session')->addError($e->getMessage());
		} catch (Exception $e) {
			Mage::getSingleton('wishlist/session')->addException($e,
			Mage::helper('wishlist')->__('Cannot create wishlist.')
			);
			return false;
		}

		return $wishlist;
	}
	public function addAction()
	{

		$response = array(); $message ='';
		if (!Mage::getStoreConfigFlag('wishlist/general/active')) {
			$response['status'] = 'ERROR';
			$message = $this->__('Wishlist Has Been Disabled By Admin');
		}
		if(!Mage::getSingleton('customer/session')->isLoggedIn()){
			$response['status'] = 'ERROR';
			$message = $this->__('Please Login First');
		}

		if(empty($response)){
			$session = Mage::getSingleton('customer/session');
			$wishlist = $this->_getWishlist();
			if (!$wishlist) {
				$response['status'] = 'ERROR';
				$message = $this->__('Unable to Create Wishlist');
			}else{

				$productId = (int) $this->getRequest()->getParam('product');
				if (!$productId) {
					$response['status'] = 'ERROR';
					$message = $this->__('Product Not Found');
				}else{

					$product = Mage::getModel('catalog/product')->load($productId);
					if (!$product->getId() || !$product->isVisibleInCatalog()) {
						$response['status'] = 'ERROR';
						$message = $this->__('Cannot specify product.');
					}else{

						try {
							$requestParams = $this->getRequest()->getParams();
							$buyRequest = new Varien_Object($requestParams);

							$result = $wishlist->addNewItem($product, $buyRequest);
							if (is_string($result)) {
								Mage::throwException($result);
							}
							$wishlist->save();

							Mage::dispatchEvent(
                				'wishlist_add_product',
							array(
			                    'wishlist'  => $wishlist,
			                    'product'   => $product,
			                    'item'      => $result
							)
							);

							Mage::helper('wishlist')->calculate();
							$message = '<span class="product-name">'.Mage::helper('core')->htmlEscape($product->getName()).'</span> '.$this->__('has been added to your wishlist.');
							$response['status'] = 'SUCCESS';

							Mage::unregister('wishlist');

							$this->loadLayout();
                            $toplink = '';
                            if($this->getLayout()->getBlock('top.links'))
                                $toplink = $this->getLayout()->getBlock('top.links')->toHtml();
                            $sidebar = '';
                            if($this->getLayout()->getBlock('wishlist_sidebar'))
                                $sidebar = $this->getLayout()->getBlock('wishlist_sidebar')->toHtml();
                            $response['sidebar'] = $sidebar;
                            $response['toplink'] = $toplink;

						}
						catch (Mage_Core_Exception $e) {
							$response['status'] = 'ERROR';
							$message = $this->__('An error occurred while adding item to wishlist: %s', $e->getMessage());
						}
						catch (Exception $e) {
							mage::log($e->getMessage());
							$response['status'] = 'ERROR';
							$message = $this->__('An error occurred while adding item to wishlist.');
						}
					}
				}
			}
		}
        $response['message'] = $message;
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
		return;
	}
}