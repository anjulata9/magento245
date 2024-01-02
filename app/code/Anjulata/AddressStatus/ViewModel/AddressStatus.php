<?php 
namespace Anjulata\AddressStatus\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\AddressRepositoryInterface;

class AddressStatus implements ArgumentInterface
{
    protected $customerSession;
    protected $addressRepository;

    public function __construct(
        Session $customerSession,
        AddressRepositoryInterface $addressRepository
    ) {
        $this->customerSession = $customerSession;
        $this->addressRepository = $addressRepository;
    }

    public function getAddressAttribute($id=null)
    {
        $customerId = $this->customerSession->getCustomer()->getId();
        $addressId = $id; // Change this to the specific address ID you want to retrieve

        try {
            $address = $this->addressRepository->getById($addressId);
            $customAttribute = $address->getCustomAttribute('address_status');
            if ($customAttribute) {
                return $customAttribute->getValue();
            }
        } catch (\Exception $e) {
            // Handle exception (e.g., address not found)
        }

        return null;
    }
}
