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
 * Discount Quickorder Cart Controller
 *
 * @category Discountcoffee
 * @package  Discountcoffee_Quickorder
 * @author   FMG Core Team <info@groupfmg.com>
 */

class Discountcoffee_Quickorder_CartController extends Mage_Core_Controller_Front_Action {

    /**
     * Predispatch action that allows to redirect to no route page in case of disabled extension through admin panel
     * 
     */
    public function preDispatch(){

        parent::preDispatch();
        if(!Mage::helper('discountcoffee_quickorder')->isEnabled()){
            $this->setFlag('','no-dispatch',TRUE);
            $this->_redirect('noRoute');
        }

    }

    /**
     * Add to cart products, which SKU specified in request
     *
     * @return void
     */
    public function addtocartAction(){

        // check empty data
        /** @var $helper Enterprise_Checkout_Helper_Data */
        $helper = Mage::helper('discountcoffee_quickorder');
        
        $sku = array_filter($this->getRequest()->getParam('sku'));
        $qty = array_filter($this->getRequest()->getParam('qty'));

        $preItems = array_combine($sku, $qty);

        if (empty($preItems)) {
            $this->_getSession()->addError($helper->getSkuEmptyDataMessageText());
            $this->_redirect('quickorder');
            return;
        }else{
            $items = array();
            foreach ($preItems as $su => $item) {
                $items[] = array('sku' => $su, 'qty' => $item);
            }
        }
        try {
            // perform data
            $cart = $this->_getItemsCart()
                ->prepareAddProductsBySku($items)
                ->saveAffectedProducts();

            $this->_getSession()->addMessages($cart->getMessages());

            if ($cart->hasErrorMessage()) {
                $this->_redirect('quickorder');
            }
            
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addException($e, $e->getMessage());
            $this->_redirect('quickorder');
        }

        $this->_redirect('checkout/cart');


    }

    /**
     * Get cart model instance
     *
     * @return Discountcoffee_Quickorder_Model_Cart
     */
    protected function _getItemsCart(){
        return Mage::getSingleton('discountcoffee_quickorder/cart')
            ->setContext(Discountcoffee_Quickorder_Model_Cart::CONTEXT_FRONTEND);
    }

    /**
     * Get checkout session model instance
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession(){
        return Mage::getSingleton('checkout/session');
    }


}
