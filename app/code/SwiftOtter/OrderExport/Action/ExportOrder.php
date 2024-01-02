<?php
declare(strict_types=1);

namespace SwiftOtter\OrderExport\Action;

use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use SwiftOtter\OrderExport\Model\HeaderData;
use SwiftOtter\OrderExport\Model\Config;
class ExportOrder
{
    /** @var OrderRepositoryInterface  */
    private OrderRepositoryInterface $orderRepository;

    /** @var Config  */
    private Config $config;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Config $config
    )
    {

        $this->orderRepository = $orderRepository;
        $this->config = $config;
    }
    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);

        if (!$this->config->isEnabled(ScopeInterface::SCOPE_STORE, $order->getStoreId())){
            throw new LocalizedException(__('Order Export is disabled'));
        }

        $results = ['success' => false, 'error' => null];

        //TODO Export to web service, save export details

        return $results;
    }
}
