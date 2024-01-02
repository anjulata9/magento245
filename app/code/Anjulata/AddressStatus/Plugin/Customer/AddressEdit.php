<?php
namespace Anjulata\AddressStatus\Plugin\Customer;

use Magento\Framework\View\LayoutInterface;
use Anjulata\AddressStatus\Block\Customer\AddressEdit as CustomerAddress;

class AddressEdit
{
    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * Constructor Initialize
     *
     * @param LayoutInterface $layout
     * @return void
     */
    public function __construct(
        LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    /**
     * Append gst field
     *
     * @param \Magento\Customer\Block\Address\Edit $edit
     * @param string $result
     * @return mixed|string
     */
    public function afterGetNameBlockHtml(
        \Magento\Customer\Block\Address\Edit $edit,
        $result
    ) {
        $customBlock =  $this->layout->createBlock(
            CustomerAddress::class,
            'address_edit_address_staus'
        );
        
        return $result.$customBlock->toHtml();
    }
}