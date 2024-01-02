<?php 
namespace Anjulata\NewEntityExample\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Anjulata\NewEntityExample\Model\MoreDetailFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Session\SessionManagerInterface;

class Save extends Action
{
	public function __construct(
        Context $context,
        MoreDetailFactory $modelMoreDetailFactory,
        PageFactory  $resultPageFactory,
        SessionManagerInterface $sessionManager    
    )
    {
        parent::__construct($context);
        $this->_modelMoreDetailFactory = $modelMoreDetailFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_sessionManager = $sessionManager;
    }

    public function execute()
    {
    	$resultRedirect     = $this->resultRedirectFactory->create();
        $data               = $this->getRequest()->getPost();
        /*echo "<pre>";
        print_r($data);exit;*/

        if(isset($data['id'])){            
            $MoreDetail = $this->_modelMoreDetailFactory->create()->load($data['id']);
        }else{
            $MoreDetail = $this->_modelMoreDetailFactory->create();
        }

        try{
        	$MoreDetail->setData('customer_id', $data['customer_id']);
	        $MoreDetail->setData('additional_contact_no', $data['additional_contact_no']);
	        $MoreDetail->setData('alternative_email', $data['alternative_email']);
	        $MoreDetail->setData('marital_status', $data['marital_status']);

	        $MoreDetail->save();

	        $this->_redirect('newentityexample/index');
	        $this->messageManager->addSuccessMessage(__('The data has been saved.'));
	    }catch (\Exception $e) {
	            $this->messageManager->addErrorMessage($e, __("We can\'t add record, Please try again."));
	        }
    }
}