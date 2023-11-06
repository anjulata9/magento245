<?php
declare(strict_types=1);
namespace Pwc\ProductInquiry\Controller\Index;

use Magento\Framework\App\RequestInterface;

class Submit extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Pwc\ProductInquiry\Model\InquiryFactory
     */
    protected $_inquiryFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Pwc\ProductInquiry\Model\InquiryFactory $inquiryFactory
    )
    {
        $this->_request = $request;
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        $this->_inquiryFactory = $inquiryFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $inquiryData = [];
        $inquiryData = $this->getRequest()->getParams();
        $store = $this->_storeManager->getStore()->getId();
        $transport = $this->_transportBuilder->setTemplateIdentifier('pwc_product_inquiry_template')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
            ->setTemplateVars(
                [
                    'subject' => (isset($inquiryData['inquiry_subject']))?$inquiryData['inquiry_subject']:'',
                    'customer_name' => (isset($inquiryData['customer_name']))?$inquiryData['customer_name']:'',
                    'customer_email' => (isset($inquiryData['customer_email']))?$inquiryData['customer_email']:'',
                    'sku' => (isset($inquiryData['sku']))?$inquiryData['sku']:'',
                    'message'   => (isset($inquiryData['inquiry_message']))?$inquiryData['inquiry_message']:''
                ]
                
            )
            ->setFrom(['email' => (isset($inquiryData['customer_email']))?$inquiryData['customer_email']:'', 'name' => (isset($inquiryData['customer_name']))?$inquiryData['customer_name']:''])
            // you can config general email address in Store -> Configuration -> General -> Store Email Addresses
            ->addTo('g.anjulata@gmail.com', 'Anjulata')
            ->getTransport();
        try {
            $transport->sendMessage();
            if(!empty($inquiryData)){
                $inquiryModel = $this->_inquiryFactory->create();
                $inquiryModel->setData($inquiryData);
                $inquiryModel->save();
            }
            $this->_redirect($inquiryData['url']);
            $this->messageManager->addSuccess(__('The inquiry has been sent.'));
        } catch (\Exception $exception) {
            $this->messageManager->addError($exception->getMessage());

        }
    }
}