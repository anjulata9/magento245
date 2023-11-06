<?php
namespace Pwc\ProductInquiry\ViewModel;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Product implements ArgumentInterface
{
    protected $registry;
    protected $productRepository;

    public function __construct(Registry $registry, ProductRepositoryInterface $productRepository)
    {
        $this->registry = $registry;
        $this->productRepository = $productRepository;
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }
}
