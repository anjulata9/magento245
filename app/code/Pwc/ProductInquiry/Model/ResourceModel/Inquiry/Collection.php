<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pwc\ProductInquiry\Model\ResourceModel\Inquiry;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection{
    protected function _construct()
    {
        $this->_init('Pwc\ProductInquiry\Model\Inquiry', 'Pwc\ProductInquiry\Model\ResourceModel\Inquiry');
    }
}