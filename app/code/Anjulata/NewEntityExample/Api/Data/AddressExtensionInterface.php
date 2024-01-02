<?php
namespace Anjulata\NewEntityExample\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface AddressExtensionInterface extends ExtensibleDataInterface
{
    public function getCustomField();
    public function setCustomField($value);
}
