<?php
namespace Anjulata\AddressStatus\Plugin\Checkout\Model;

use Magento\Quote\Model\QuoteRepository;
use \Psr\Log\LoggerInterface;

class ShippingInformationManagement{
    
    protected $quoteRepository;
    protected $logger;

    public function __construct(QuoteRepository $quoteRepository,  LoggerInterface $logger) {
        $this->quoteRepository = $quoteRepository;
        $this->logger = $logger;
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        $shippingAddress = $addressInformation->getShippingAddress();
        $extensionAttributes = $shippingAddress->getExtensionAttributes();

        if ($extensionAttributes) {
            if ($extensionAttributes->getAddressStatus()) {
                $addressStatus = $extensionAttributes->getAddressStatus();
                $shippingAddress->setAddressStatus($addressStatus);
            } else {
                $shippingAddress->setAddressStatus('');
            }
        }
    }
}