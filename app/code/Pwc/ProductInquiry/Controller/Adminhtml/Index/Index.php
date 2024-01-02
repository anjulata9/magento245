<?php
declare(strict_types=1);
namespace Pwc\ProductInquiry\Controller\Adminhtml\Index;
 
class Index extends \Magento\Backend\App\Action
 
{
    //const ADMIN_RESOURCE = 'Pwc_ProductInquiry::inquiries_list';
    protected $resultPageFactory;
 
    public function __construct(
 
        \Magento\Backend\App\Action\Context $context,
 
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
 
    ) {
 
        parent::__construct($context);
 
        $this->resultPageFactory = $resultPageFactory;
 
    }
 
    public function execute()
 
    {
 
        $resultPage = $this->resultPageFactory->create();
 
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Grid'));
 
        return $resultPage;
 
    }
 
}