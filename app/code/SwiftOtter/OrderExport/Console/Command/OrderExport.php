<?php

namespace SwiftOtter\OrderExport\Console\Command;

use SwiftOtter\OrderExport\Action\CollectOrderData;
use SwiftOtter\OrderExport\Model\HeaderData;
use SwiftOtter\OrderExport\Model\HeaderDataFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExport extends Command
{
    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_MERCHANT_NOTE = 'notes';

    /** @var HeaderDataFactory */
    private $headerDataFactory;
    private CollectOrderData $collectOrderData;

    public function __construct(
        HeaderDataFactory $headerDataFactory,
        CollectOrderData $collectOrderData,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->headerDataFactory = $headerDataFactory;
        $this->collectOrderData = $collectOrderData;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('order-export:run')
            ->setDescription('Export order to ERP')
            ->addArgument(
                self::ARG_NAME_ORDER_ID,
                InputArgument::REQUIRED,
                "Order ID"
            )
            ->addOption(
                self::OPT_NAME_SHIP_DATE,
                'd',
                InputOption::VALUE_OPTIONAL,
                'Shipping date in formate YYYY-MM_DD'
            )
            ->addOption(
                self::OPT_NAME_MERCHANT_NOTE,
                null,
                InputOption::VALUE_OPTIONAL,
                'Merchant notes'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orderId = (int) $input->getArgument(self::ARG_NAME_ORDER_ID);
        $notes = $input->getOption(self::OPT_NAME_MERCHANT_NOTE);
        $shipDate = $input->getOption(self::OPT_NAME_SHIP_DATE);

        /** @var HeaderData $headerData */
        $headerData = $this->headerDataFactory->create();
        if($shipDate){
            $headerData->setShipDate(new \DateTime($shipDate));
        }
        if($notes){
            $headerData->setMerchantNotes($notes);
        }
        $orderData = $this->collectOrderData->execute($orderId, $headerData);

        $output->writeln(print_r($orderData, true));
        //$output->writeln(print_r($headerData, true));
        /*$output->writeln(__('Order ID id %1', $orderId));
        $output->writeln(__('Notes is %1', $notes));
        $output->writeln(__('Ship date is %1', $shipDate));*/

        return 0 ;
    }
}