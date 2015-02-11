<?php
/**
 * FMG
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category Discountcoffee
 * @package Discountcoffee_Quickorder
 * @copyright Copyright (c) 2013 Group FMG. (http://www.groupfmg.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

/**
 * Discount Quickorder index form
 *
 * @category Discountcoffee
 * @package  Discountcoffee_Quickorder
 * @author   FMG Core Team <info@groupfmg.com>
 */

class Discountcoffee_Quickorder_Block_View extends Mage_Core_Block_Template{

    /**
     * Get Form Action Url
     * 
     * @return string | URL 
     */
    public function getFormActionUrl(){
        return $this->getUrl('quickorder/cart/addtocart');
    }

}