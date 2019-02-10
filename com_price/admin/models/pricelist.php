<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;

class PriceModelPricelist extends ListModel
{
	public function __construct($config = [])
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = ['ordering', 'published', 'title', 'unit', 'val', 'id', 'category_id', 'unit_id', 'catid'];
		}
		parent::__construct($config);
	}

	protected function populateState($ordering = 'ordering', $direction = 'asc')
	{
		$this->setState('filter.search', $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search', '', 'string'));
		$this->setState('filter.published', $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', ''));
		$this->setState('filter.category_id', $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id'));
		$this->setState('filter.unit_id', $this->getUserStateFromRequest($this->context . '.filter.unit_id', 'filter_unit_id'));
		parent::populateState($ordering, $direction);
	}

	protected function getStoreId($id = '')
	{
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.category_id');
		$id .= ':' . $this->getState('filter.unit_id');
		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		$query = $this->getDbo()->getQuery(true)
			->select('p.id, p.title, p.val, p.published, p.ordering, c.id as category_id, c.title as category_title, u.name as unit')
			->leftJoin('#__categories as c on c.id=p.catid')
			->leftJoin('#__pricelist_points as u on u.id=p.unit')
			->from('#__pricelist as p');

		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('p.published=' . (int)$published);
		}

		$catid = $this->getState('filter.category_id');
		if (is_numeric($catid)) {
			$query->where('p.catid=' . (int)$catid);
		}

		$unitid = $this->getState('filter.unit_id');
		if (is_numeric($unitid)) {
			$query->where('p.unit=' . (int)$unitid);
		}

		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$search = $this->getDbo()->Quote('%' . $this->getDbo()->escape($search, true) . '%');
			$query->where('(p.title like ' . $search . ')');
		}

		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		$query->order($this->getDbo()->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	public function getAllCount()
	{
		return (int)$this->getDbo()->setQuery('select count(*) from `#__pricelist`')->loadResult();
	}
}
