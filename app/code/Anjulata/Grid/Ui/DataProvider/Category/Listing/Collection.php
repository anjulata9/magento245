<?php
/**
 * Copyright &copy; Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Anjulata\Grid\Ui\DataProvider\Category\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
	/**
	 * Override _initSelect to add custom columns
	 * 
	 * @return void
	 */
	protected function _initSelect()
	{
		$this->addFilterToMap('entity_id', 'main_table.entity_id');
		$this->addFilterToMap('name', 'anjulatagridname.value');
		parent::_initSelect();
	} 
}
