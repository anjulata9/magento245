<?php
/**
 * Copyright &copy; Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Anjulata\Grid\Plugin;

use Anjulata\Grid\Ui\DataProvider\Category\ListingDataProvider as CategoryDataProvider;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class AddAttributesToUiDataProvider
{
	/** @var AttributeRepositoryInterface */
	private $attributeRepository;

	/** @var ProductMetadataInterface */
	private $productMetadata;

	/**
	 * Constructor
	 * 
	 * @param AttributeRepositoryInterface $attributeRepository
	 * @param ProductMetadataInterface $productMetadata
	 */
	public function __construct(
		AttributeRepositoryInterface $attributeRepository,
		ProductMetadataInterface $productMetadata
	) {
		$this->attributeRepository = $attributeRepository;
		$this->productMetadata = $productMetadata;
	}

	/**
	 * Get search result after plugin
	 * 
	 * @param CategoryDataProvider $subject
	 * @param SearchResult $result
	 * @return SearchResult
	 */
	public function afterGetSearchResult(CategoryDataProvider $subject, SearchResult $result)
	{
		if($result->isLoaded()){
			return $result;
		}

		$edition = $this->productMetadata->getEdition();
		$column = 'entity_id';

		if ($edition == 'Enterprise') {
			$column = 'row_id';
		}

		$attribute = $this->attributeRepository->get('catalog_category','name');

		$result->getSelect()->joinLeft(
			['anjulatagridname' => $attribute->getBackendTable()],
			'anjulatagridname.'. $column . ' = main_table.'. $column . ' AND anjulatagridname.attribute_id = '. $attribute->getAttributeId(),
			['name' => 'anjulatagridname.value']
		);

		$result->getSelect()->where('anjulatagridname.value LIKE "B%"');

		return $result;
	} 
} 
