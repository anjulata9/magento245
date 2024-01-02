<?php
namespace Anjulata\NewEntityExample\Plugin;

use Anjulata\NewEntityExample\Api\Data\AddressExtensionInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Anjulata\NewEntityExample\Model\MoreDetailFactory;

class AddCustomFieldToCustomerAddress
{
    protected $moreDtailFactory;

    public function __construct(
        MoreDetailFactory $moreDtailFactory
    ) {
        $this->moreDtailFactory = $moreDtailFactory;
    }

    public function afterGetById(
        \Magento\Customer\Api\AddressRepositoryInterface $subject,
        AddressInterface $address
    ) {
        // Load your custom table data based on the address information and set it in the extension attribute
        $customerId = $address->getCustomerId();
        $customerExtraData = $this->moreDtailFactory->create()->load($customerId, 'customer_id');
        
        // Map the retrieved data to the extension attribute
        $meritalStatus = $customerExtraData->getMaritalStatus() ?? null;
        
        if ($meritalStatus) {
            $extensionAttributes = $address->getExtensionAttributes();
            $extensionAttributes->setMaritalStatus($meritalStatus);
            $address->setExtensionAttributes($extensionAttributes);
        }

        return $address;
    }
}
