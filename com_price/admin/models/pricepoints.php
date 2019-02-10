<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;

class PriceModelPricepoints extends ListModel
{
	public function __construct($config = [])
	{
		parent::__construct($config);
	}

	protected function populateState($ordering = 'id', $direction = 'asc')
	{
		parent::populateState($ordering, $direction);
	}

	protected function getStoreId($id = '')
	{
		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		$query = $this->getDbo()->getQuery(true)
			->select('id, name')
			->from('#__pricelist_points');

		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		$query->order($this->getDbo()->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	public function getAllCount()
	{
		return (int)$this->getDbo()->setQuery('select count(*) from `#__pricelist_points`')->loadResult();
	}
}
