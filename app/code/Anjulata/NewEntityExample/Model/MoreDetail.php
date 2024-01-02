<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Anjulata\NewEntityExample\Model;
use Magento\Framework\Model\AbstractModel;

class MoreDetail extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Anjulata\NewEntityExample\Model\ResourceModel\MoreDetail');
    }
}
