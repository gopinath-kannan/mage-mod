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
 * Discount Quickorder Methods Helper
 *
 * @category Discountcoffee
 * @package  Discountcoffee_Quickorder
 * @author   FMG Core Team <info@groupfmg.com>
 */
?>
<?php
class Discountcoffee_Quickorder_Helper_Data extends Mage_Core_Helper_Abstract{

    const XML_PATH_ENABLED = 'quickorder/view/enabled';
    const XML_PATH_ROWS_COUNT = 'quickorder/view/rows_per_view';

    /**
     * Status of item, that was added by SKU
     */
    const ADD_ITEM_STATUS_SUCCESS = 'success';
    const ADD_ITEM_STATUS_FAILED_SKU = 'failed_sku';
    const ADD_ITEM_STATUS_FAILED_OUT_OF_STOCK = 'failed_out_of_stock';
    const ADD_ITEM_STATUS_FAILED_QTY_ALLOWED = 'failed_qty_allowed';
    const ADD_ITEM_STATUS_FAILED_QTY_ALLOWED_IN_CART = 'failed_qty_allowed_in_cart';
    const ADD_ITEM_STATUS_FAILED_QTY_INVALID_NUMBER = 'failed_qty_invalid_number';
    const ADD_ITEM_STATUS_FAILED_QTY_INVALID_NON_POSITIVE = 'failed_qty_invalid_non_positive';
    const ADD_ITEM_STATUS_FAILED_QTY_INVALID_RANGE = 'failed_qty_invalid_range';
    const ADD_ITEM_STATUS_FAILED_QTY_INCREMENTS = 'failed_qty_increment';
    const ADD_ITEM_STATUS_FAILED_CONFIGURE = 'failed_configure';
    const ADD_ITEM_STATUS_FAILED_PERMISSIONS = 'failed_permissions';
    const ADD_ITEM_STATUS_FAILED_WEBSITE = 'failed_website';
    const ADD_ITEM_STATUS_FAILED_UNKNOWN = 'failed_unknown';
    const ADD_ITEM_STATUS_FAILED_EMPTY = 'failed_empty';
    const ADD_ITEM_STATUS_FAILED_DISABLED = 'failed_disabled';

    /**
     * Contains session object to which data is saved
     *
     * @var Mage_Core_Model_Session_Abstract
     */
    protected $_session;

    /**
     * Checks weather news can be displayed in the frontend
     * 
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null){
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }

    /**
     * Get rows count for the quick order form
     * 
     * @param integer|string|Mage_Core_Model_Store $store
     * @return integer
     */
    public function getRowsCount($store = null){
        return Mage::getStoreConfig(self::XML_PATH_ROWS_COUNT, $store);
    }

    /**
     * Get URL for Lookup Request
     * 
     * @param null 
     * @return string | URL
     */
    public function getLookupUrl(){
        return Mage::getUrl('quickorder/index/lookupproduct');
    }

    /**
     * Get error message for empty records
     * 
     * @param null 
     * @return string 
     */

    public function getSkuEmptyDataMessageText(){
        return $this->__('SKU is Empty');
    }

    /**
     * Return session for affected items
     *
     * @return Mage_Core_Model_Session_Abstract
     */
    public function getSession()
    {
        if (!$this->_session) {
            $sessionClassPath = Mage::app()->getStore()->isAdmin() ? 'adminhtml/session' : 'customer/session';
            $this->_session =  Mage::getSingleton($sessionClassPath);
        }

        return $this->_session;
    }

}
