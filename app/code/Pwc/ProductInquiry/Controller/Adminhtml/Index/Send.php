<?php
declare(strict_types=1);
namespace Pwc\ProductInquiry\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Pwc\ProductInquiry\Model\InquiryFactory;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Send extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Pwc\ProductInquiry\Model\InquiryFactory
     */
    protected $inquiryFactory;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        InquiryFactory $inquiryFactory
    ) {
        parent::__construct($context);
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->inquiryFactory = $inquiryFactory;
    }
    /**
     * Send email controller page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $inquiryId = $this->getRequest()->getParam('id');
        $recipientName = $this->getRequest()->getParam('customer_name');
        $recipientEmail = $this->getRequest()->getParam('customer_email');
        $subject = $this->getRequest()->getParam('subject');
        $message = $this->getRequest()->getParam('reason');

        // Customize the email template ID according to your requirements
        $templateId = 'pwc_product_inquiry_reply_template';

        $storeId = $this->storeManager->getStore()->getId();

        $transport = $this->transportBuilder
            ->setTemplateIdentifier($templateId)
            ->setTemplateOptions([
                'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
                'store' => $storeId,
            ])
            ->setTemplateVars(['customer' => $recipientName,'message' => $message])
            ->setFrom(['email' => 'g.anjulata@gmail.com', 'name' => 'Admin'])
            ->addTo($recipientEmail, $recipientName)
            ->getTransport();

        try {
            $this->inlineTranslation->suspend();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            $this->messageManager->addSuccessMessage(__('Email sent successfully.'));

            if(isset($inquiryId)){
                $inquiryModel = $this->inquiryFactory->create();
                $data['id'] = $inquiryId;
                $data['status'] = 'Repied';
                $data['response'] = $message;                
                $inquiryModel->setData($data);
                $inquiryModel->save();
            }
            $this->_redirect('productinquiry/index/index');
            $this->messageManager->addSuccess(__('The reply message has been sent.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Unable to send email. Please try again later.'));
        }

        $this->_redirect('*/*/index'); // Redirect to your response grid or form
    }
}