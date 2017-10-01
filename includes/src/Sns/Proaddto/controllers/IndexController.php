<?php
require_once 'Mage/Checkout/controllers/CartController.php';
class Sns_Proaddto_IndexController extends Mage_Checkout_CartController
{
	public function addAction()
	{
		$cart   = $this->_getCart();
		$params = $this->getRequest()->getParams();
		if($params['isAjax'] == 1){
			$response = array();
			try {
				if (isset($params['qty'])) {
					$filter = new Zend_Filter_LocalizedToNormalized(
					array('locale' => Mage::app()->getLocale()->getLocaleCode())
					);
					$params['qty'] = $filter->filter($params['qty']);
				}

				$product = $this->_initProduct();
				$related = $this->getRequest()->getParam('related_product');

				/* Check product availabel */
				if (!$product) {
					$response['status'] = 'ERROR';
					$response['message'] = $this->__('Unable to find Product ID');
				}

				$cart->addProduct($product, $params);
				if (!empty($related)) {
					$cart->addProductsByIds(explode(',', $related));
				}

				$cart->save();

				$this->_getSession()->setCartWasUpdated(true);

				/* Remove wishlist observer process AddToCart */
				Mage::dispatchEvent('checkout_cart_add_product_complete',
				array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
				);

				if (!$cart->getQuote()->getHasError()){
                    $scode = Mage::app()->getStore()->getCode();
                    $width = Mage::getStoreConfig('sns_proaddto_cfg/confirmbox/width', $scode);
                    $height = Mage::getStoreConfig('sns_proaddto_cfg/confirmbox/height', $scode);
                    $product_image_src = Mage::helper('catalog/image')->init($product, 'small_image')->resize($width,$height);
                    $product_image = '<p><img src="'.$product_image_src.'" class="product-image" alt=""/></p>';
					$message = '<p>'.$this->__("You've just added this product to the cart: ")
                                .'<span class="product-name">'.Mage::helper('core')->htmlEscape($product->getName()).'</span></p>'
                                .$product_image.
                                '<div class="sns-btnproaddto-wrap">
                                    <button type="button" name="finish_and_checkout" id="finish_and_checkout" class="button btn-confirm-addtocart">
                                        '.$this->__("Shopping cart").'
                                    </button>
                                    <button type="button" name="continue_shopping" id="continue_shopping" class="button btn-confirm-addtocart" >
                                        '.$this->__("Continue").'
                                    </button>
                                </div>';
                
					$response['status'] = 'SUCCESS';
					$response['message'] = $message;

					$this->loadLayout();
                    $toplink = "";
                    if($this->getLayout()->getBlock('top.links'))
                                $toplink = $this->getLayout()->getBlock('top.links')->toHtml();
                    $minicart = "";
                    if($this->getLayout()->getBlock('minicart'))
                        $minicart = $this->getLayout()->getBlock('minicart')->toHtml();
                    $cart_sidebar = "";
                    if($this->getLayout()->getBlock('cart_sidebar'))
                        $cart_sidebar = $this->getLayout()->getBlock('cart_sidebar')->toHtml();
                    
                    $response['formKey'] = Mage::helper('core/url')->getEncodedUrl();
                    $response['minicart'] = $minicart;
                    $response['toplink'] = $toplink;
                    $response['cart_sidebar'] = $cart_sidebar;
				}
			} catch (Mage_Core_Exception $e) {
				$msg = "";
				if ($this->_getSession()->getUseNotice(true)) {
					$msg = $e->getMessage();
				} else {
					$messages = array_unique(explode("\n", $e->getMessage()));
					foreach ($messages as $message) {
						$msg .= $message.'<br/>';
					}
				}

				$response['status'] = 'ERROR';
				$response['message'] = $msg;
			} catch (Exception $e) {
				$response['status'] = 'ERROR';
				$response['message'] = $this->__('Cannot add the item to shopping cart.');
				Mage::logException($e);
			}
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
			return;
		}else{
			return parent::addAction();
		}
	}
}