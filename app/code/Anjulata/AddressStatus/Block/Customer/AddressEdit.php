<?php
namespace Anjulata\AddressStatus\Block\Customer;

use Magento\Framework\View\Element\Template;
use Anjulata\AddressStatus\Block\Customer\Widget\AddressStatus;

class AddressEdit extends Template
{
    /**
     * To html
     *
     * @return string
     */
    protected function _toHtml()
    {
        $addressStatusWidgetBlock = $this->getLayout()->createBlock(AddressStatus::class);
        return $addressStatusWidgetBlock->toHtml();
    }
}