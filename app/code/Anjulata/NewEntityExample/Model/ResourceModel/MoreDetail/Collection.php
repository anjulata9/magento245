<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Anjulata\NewEntityExample\Model\ResourceModel\MoreDetail;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Anjulata\NewEntityExample\Model\MoreDetail', 'Anjulata\NewEntityExample\Model\ResourceModel\MoreDetail');
    }
}
