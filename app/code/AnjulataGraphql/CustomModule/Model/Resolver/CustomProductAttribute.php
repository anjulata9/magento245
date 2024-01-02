<?php

namespace AnjulataGraphql\CustomModule\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Catalog\Model\Product\Attribute\Repository;

class CustomProductAttribute implements ResolverInterface
{
    /**
     * @var Repository
     */
    private $attributeRepository;

    public function __construct(Repository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $attributeId = $args['id'];
        $attribute = $this->attributeRepository->get($attributeId);

        return [
            'attribute_id' => $attribute->getId(),
            'attribute_code' => $attribute->getAttributeCode(),
            'frontend_label' => $attribute->getFrontendLabel(),
        ];
    }
}
