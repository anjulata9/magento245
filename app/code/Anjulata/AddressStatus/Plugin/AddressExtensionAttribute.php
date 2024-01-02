<?php
namespace Anjulata\AddressStatus\Plugin;


use Magento\Customer\Api\AddressRepositoryInterface;

class AddressExtensionAttribute
{
    public function afterGetById(
        AddressRepositoryInterface $subject,
        $result
    ) {
        $extensionAttribute = $result->getExtensionAttributes();
        $extensionAttribute->setAddressStatus("Inprogress");
        $result->setExtensionAttributes($extensionAttribute);

        return $result;
    }
}
