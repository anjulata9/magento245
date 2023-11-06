<?php 
declare(strict_types=1);

namespace Pwc\ProductInquiry\Test\Unit\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Mail\TransportInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\TestFramework\TestCase\AbstractController;
use Pwc\ProductInquiry\Controller\Index\Submit;
use Pwc\ProductInquiry\Model\InquiryFactory;
use Pwc\ProductInquiry\Model\Inquiry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class SubmitTest
 *
 * Test of form and email validation.
 */
class SubmitTest extends TestCase
{
	/**
     * Testable Object
     *
     * @var Submit
     */
    private $submit;

	/**
     * @var Context|MockObject
     */
    private $contextMock;

    /**
     * @var MockObject
     */
    protected $requestMock;

    /**
     * @var Http|MockObject
     */
    protected $request;

    /**
     * @var TransportBuilder|MockObject
     */
    private $transportBuilderMock;

    /**
     * @var MockObject
     */
    private $storeManagerMock;

    /**
     * @var InquiryFactory|MockObject
     */
    private $inquiryFactoryMock;

    protected $inquiryFactory;
    protected $inquiryModel;
    protected $messageManager;
    
	protected function setUp(): void
    {
    	$context = $this->createMock(Context::class);
        $this->request = $this->createMock(RequestInterface::class);
        /*$context->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);*/

    	$this->contextMock = $this->createMock(Context::class);
        $this->requestMock = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getParams', 'isDispatched', 'setDispatched', 'initForward', 'setActionName'])
            ->getMock(); 
        $this->contextMock->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestMock); 
        /*$this->request = $this->getMockBuilder(Http::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getParams'])
            ->getMock();*/
        $this->transportBuilderMock = $this->getMockBuilder(TransportBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->storeManagerMock = $this->getMockForAbstractClass(StoreManagerInterface::class);
        $this->inquiryFactoryMock = $this->getMockBuilder(InquiryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->inquiryFactory = $this->getMockBuilder(InquiryFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->inquiryModel = $this->getMockBuilder(Inquiry::class)
            ->disableOriginalConstructor()
            ->setMethods(['setData', 'save'])
            ->getMock();
        $this->messageManager = $this->getMockBuilder(\Magento\Framework\Message\ManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->submit = new Submit(
        	$this->contextMock,
        	$this->requestMock,            
            $this->transportBuilderMock,
            $this->storeManagerMock,
            $this->inquiryFactoryMock,
            $this->messageManager
        );
    }
    
    /**
     * Test execute
     */
    public function testExecute(): void
    {
    	$this->requestMock->expects($this->once())
            ->method('getParams')
            ->willReturn(['id' => 1]);

     	$email = 'reply-to@example.com';
        $templateVars = [
        	'subject' => '',
        	'customer_name' => '',
        	'customer_email' => '',
        	'sku' => '',
        	'message' => ''
        ];
        $transport = $this->getMockForAbstractClass(TransportInterface::class);
        $storeMock = $this->getMockForAbstractClass(StoreInterface::class);
        $storeMock->expects($this->once())->method('getId')->willReturn(555);
           
        $this->storeManagerMock->expects($this->once())->method('getStore')->willReturn($storeMock);

        $this->transportBuilderMock->expects($this->once())
            ->method('setTemplateIdentifier')->willReturnSelf();
        $this->transportBuilderMock->expects($this->once())
            ->method('setTemplateOptions')
            ->with(
                [
                    'area' => 'frontend',
                    'store' => 555,
                ]
            )->willReturnSelf();
        $this->transportBuilderMock->expects($this->once())
            ->method('setTemplateVars')
            ->with($templateVars)->willReturnSelf();
        $this->transportBuilderMock->expects($this->once())
            ->method('setFrom')->willReturnSelf();
        $this->transportBuilderMock->expects($this->once())
            ->method('addTo')->willReturnSelf();        
        $this->transportBuilderMock->expects($this->once())
            ->method('getTransport')
            ->willReturn($transport);

        $transport->expects($this->once())
            ->method('sendMessage');

         // Set up the request parameters for your test
        $requestData = [
            'inquiry_subject' => 'Test Subject',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'sku' => 'ABC123',
            'inquiry_message' => 'This is a test inquiry message',
            'url' => 'http://example.com',
        ];
        // Mock InquiryFactory behavior
        $inquiryModel = $this->createMock(\Pwc\ProductInquiry\Model\Inquiry::class);
        $this->inquiryFactoryMock->expects($this->once())->method('create')->willReturn($inquiryModel);
        $inquiryModel->expects($this->once())->method('setData')->with($requestData);
        $inquiryModel->expects($this->once())->method('save');

        // Set up expectations for the message manager
        $this->messageManager->expects($this->once())
            ->method('addSuccess')
            ->with('The inquiry has been sent.');

        $this->messageManager->expects($this->once())
            ->method('addError')
            ->with('The inquiry has been not sent.');

        

        $this->submit->execute();
    }
}