<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class PriceModelPricelist extends BaseDatabaseModel
{
	public function getItems()
	{
		$query = $this->_db->getQuery(true)
			->select('id, level, title, alias, note')
			->from('#__categories')
			->where('extension="com_price"')
			->where('published=1')
			->order('lft asc');
		$categories = $this->_db->setQuery($query)->loadObjectList('id');

		$query = $this->_db->getQuery(true)
			->select('p.id, p.title, p.val, p.catid, u.name as unit')
			->from('#__pricelist as p')
			->leftJoin('`#__categories` as c on c.`id`=p.`catid`')
			->leftJoin('`#__pricelist_points` as u on u.`id`=p.`unit`')
			->where('c.published=1')
			->where('p.published=1')
			->order('p.ordering asc');
		$items = $this->_db->setQuery($query)->loadObjectList();

		foreach ($items as $item) {
			if (isset($categories[$item->catid])) {
				$categories[$item->catid]->items[] = $item;
			}
		}
		unset($items);

		return $categories;
	}
}