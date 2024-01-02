<?php
namespace Anjulata\Demo\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class CustomController extends Action
{
    public function execute()
    {
        // Your controller logic here
        $response = 'Hello from Custom Controller!'; // Example response

        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($response);

        return $result;
    }
}
