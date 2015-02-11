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
 * Discount Quickorder Controller
 *
 * @category Discountcoffee
 * @package  Discountcoffee_Quickorder
 * @author   FMG Core Team <info@groupfmg.com>
 */

class Discountcoffee_Quickorder_IndexController extends Mage_Core_Controller_Front_Action {

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
     * Get Quick order form view
     * 
     * @return null | html
     */
    public function indexAction(){

        $this->loadLayout();
        $this->renderLayout();

    }

    /**
     * Search product by SKU
     * 
     * @return null | html
     */
    public function lookupproductAction(){
        
        if($this->getRequest()->isXmlHttpRequest()){
            $productSKU = trim($this->getRequest()->getPost('sku'));
            $qty = (int) $this->getRequest()->getPost('qty');
            $_product = Mage::getModel('catalog/product')->loadByAttribute('sku',$productSKU);
            $contentJSON = array('status' => 0, 'content' => '<span class="error">Item not found - please enter all numbers and letters</span>');
            if($productSKU && ($_product && $_product->getId() && $_product->getStatus() == 1 && $_product->getVisibility() != 1)){
                if($_product->getTypeId()!='simple'){
                    $contentJSON['content'] = '<span class="error link-external">The requested product has diferent available options. <a target="_blank" href="'.$_product->getProductUrl().'">Go to the product page to add it to your cart.</a></span>';
                }else{
                    $price = Mage::helper('core')->currency($_product->getFinalPrice(), true, false);
                    $totalPrice = Mage::helper('core')->currency(($_product->getFinalPrice() * $qty), true, false);
                    $contentJSON = array('status' => 1, 'qty' => $qty,'name' => '<img src="'.(string)Mage::helper('catalog/image')->init($_product, 'image')->resize(100).'" /><a href="'.$_product->getProductUrl().'" target="_blank"><span>'.$_product->getName().'</span></a>','price' => $price,'row_total' => $totalPrice );
                }
            }else if($productSKU && ($_product && $_product->getId() && $_product->getStatus() == 1 && $_product->getTypeId() == "simple")){

			    $parentIds = Mage::getModel('catalog/product_type_grouped')->getParentIdsByChild($_product->getId());
			    if(isset($parentIds[0])){
			        $parent = Mage::getModel('catalog/product')->load($parentIds[0]);
					if($parent && $parent->getId() && $parent->getStatus() == 1 && $parent->getVisibility() != 1){
	                    $price = Mage::helper('core')->currency($_product->getFinalPrice(), true, false);
	                    $totalPrice = Mage::helper('core')->currency(($_product->getFinalPrice() * $qty), true, false);
						$contentJSON = array('status' => 1, 'qty' => $qty,'name' => '<img src="'.(string)Mage::helper('catalog/image')->init($_product, 'image')->resize(100).'" /><a target="_blank" href="'.$parent->getProductUrl().'"><span>'.$_product->getName().'</span></a>','price' => $price,'row_total' => $totalPrice );
					}
				}

			}
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode($contentJSON));
            $this->setFlag('', self::FLAG_NO_POST_DISPATCH, true);
        }else{
            $this->setFlag('','no-dispatch',TRUE);
            $this->_redirect('noRoute');
        }

    }

    public function loadAjaxProduct(){

        /*$formId = $this->getRequest()->getPost('formId');
        $captchaModel = Mage::helper('captcha')->getCaptcha($formId);
        $this->getLayout()->createBlock($captchaModel->getBlockName())->setFormId($formId)->setIsAjax(true)->toHtml();
        $this->getResponse()->setBody(json_encode(array('imgSrc' => $captchaModel->getImgSrc())));
        $this->setFlag('', self::FLAG_NO_POST_DISPATCH, true);*/

    }

}
