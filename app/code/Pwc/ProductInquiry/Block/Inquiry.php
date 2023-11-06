<?php
namespace Pwc\ProductInquiry\Block;

use Magento\Framework\View\Element\Template;
use Pwc\ProductInquiry\ViewModel\Product;
use Magento\Catalog\Model\ProductFactory;

class Inquiry extends Template
{
    protected $productViewModel;
    protected $productFactory;

    public function __construct(
        Template\Context $context,
        Product $productViewModel,
        ProductFactory $productFactory,
        array $data = []
    ) {
        $this->productViewModel = $productViewModel;
        $this->productFactory = $productFactory;
        parent::__construct($context, $data);
    }

    public function getCurrentProduct()
    {
        return $this->productViewModel->getProduct();
    }

    public function getProductDetails()
    {
        $product = $this->getCurrentProduct();
        $productDetails = [];

        if ($product) {
            $productDetails['id'] = $product->getEntityId();
            $productDetails['name'] = $product->getName();
            $productDetails['sku'] = $product->getSku();
            $productDetails['url'] = $product->getProductUrl();
        }

        return $productDetails;
    }

    public function getFormAction()
    {
        return $this->getUrl('productinquiry/index/submit');
    }
}
