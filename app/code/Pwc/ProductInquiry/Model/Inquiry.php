<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pwc\ProductInquiry\Model;
use Magento\Framework\Model\AbstractModel;

class Inquiry extends \Magento\Framework\Model\AbstractModel {

    const CACHE_TAG = 'id';
    
    protected function _construct() {
        $this->_init('Pwc\ProductInquiry\Model\ResourceModel\Inquiry');
    }

    public function getIdentities() 
    { 
        return [self::CACHE_TAG . '_' . $this->getId()]; 
    }
}