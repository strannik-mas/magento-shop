<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_ConfigurableSwatches
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Class implementing the media fallback layer for swatches
 */
class Sns_Lamino_Helper_Mediafallback extends Mage_ConfigurableSwatches_Helper_Mediafallback
{
    protected function _resizeProductImage($product, $type, $keepFrame, $image = null, $placeholder = false)
    {
        $hasTypeData = $product->hasData($type) && $product->getData($type) != 'no_selection';
        if ($image == 'no_selection') {
            $image = null;
        }
        if ($hasTypeData || $placeholder || $image) {
            	$height = Mage::helper('catalog/image')->init($product, 'image')->getOriginalHeight();
            	$width = Mage::helper('catalog/image')->init($product, 'image')->getOriginalWidth();
            	
            $helper = Mage::helper('catalog/image');
            $helper->init($product, $type, $image);
            $helper->keepFrame(true);
            //$helper->keepFrame(($hasTypeData || $image) ? $keepFrame : false);  // don't keep frame if placeholder

			$imgSize = Mage::helper('lamino/data')->getImgSize('L');
			
            //$size = Mage::getStoreConfig(Mage_Catalog_Helper_Image::XML_NODE_PRODUCT_BASE_IMAGE_WIDTH);
            //if ($type == 'small_image') {
             //   $size = Mage::getStoreConfig(Mage_Catalog_Helper_Image::XML_NODE_PRODUCT_SMALL_IMAGE_WIDTH);
            //}
            //if (is_numeric($size)) {
             //   $helper->constrainOnly(true)->resize($imgSize[0], $imgSize[1]);
            //}
            //$helper->constrainOnly(true)->resize($imgSize[0], $imgSize[1]);
           // return (string)$helper;
            if ($type == 'small_image') {
                $helper->constrainOnly(true)->resize($imgSize[0], $imgSize[1]);
            } else {

            	$imgSize = Mage::helper('lamino/data')->getImgSize('XL');
            	$imgRate = Mage::helper('lamino/data')->getImgRate();
            	
				if($width > $height) {
					$resizeW = $width;
					if($width < $imgSize[0]) $resizeW = $imgSize[0];
					$resizeH = $resizeW / $imgRate;
				} else {
					$resizeH = $height;
					if($height < $imgSize[1]) $resizeH = $imgSize[1];
					$resizeW = $resizeH * $imgRate;
				}
            	$helper->constrainOnly(true)->resize($resizeW, $resizeH);
            }
            return (string)$helper;
        }
        return false;
    }

}
