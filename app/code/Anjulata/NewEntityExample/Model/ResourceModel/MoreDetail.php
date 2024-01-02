<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Anjulata\NewEntityExample\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MoreDetail extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @retrun void
     */
    protected function _construct()
    {
        $this->_init('customer_extra_detail', 'id');
    }
}
