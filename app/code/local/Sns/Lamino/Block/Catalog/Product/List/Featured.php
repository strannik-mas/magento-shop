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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Catalog product random items block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
 
class Sns_Lamino_Block_Catalog_Product_List_Featured extends Mage_Catalog_Block_Product_List
{
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
        	$layer = $this->getLayer();
        	
            $categoryID = $this->getCategoryId();
            if($categoryID) {
              $category = new Mage_Catalog_Model_Category();
              $category->load($categoryID); // this is category id
              $collection = $category->getProductCollection();
            } else {
              $collection = Mage::getResourceModel('catalog/product_collection');
            }
            Mage::getModel('catalog/layer')->prepareProductCollection($collection);

			$collection->addAttributeToFilter('is_featured', array('eq' => "1"));

            $this->_productCollection = $collection;
        }
        return $this->_productCollection;
    }
}