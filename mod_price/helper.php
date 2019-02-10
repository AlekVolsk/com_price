<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class ModPriceHelper
{
	public static function getList(&$params)
	{
		$categories = '';

		$ids = $params->get('catids');

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('id, level, title, alias, note')
			->from('#__categories')
			->where('extension="com_price"')
			->where('published=1');

		if (isset($ids) and $ids) {
			$query->where('id in (' . implode(',', $ids) . ')');
		}

		$categories = $db->setQuery($query)->loadObjectList('id');

		$query = $db->getQuery(true)
			->select('p.id, p.title, p.val, p.catid, u.name as unit')
			->from('#__pricelist as p')
			->leftJoin('`#__categories` as c on c.`id`=p.`catid`')
			->leftJoin('`#__pricelist_points` as u on u.`id`=p.`unit`')
			->where('c.published=1')
			->where('p.published=1')
			->order('p.ordering asc');
		$items = $db->setQuery($query)->loadObjectList();

		foreach ($items as $item) {
			if (isset($categories[$item->catid])) {
				$categories[$item->catid]->items[] = $item;
			}
		}
		unset($items);

		foreach ($categories as $key => $cat) {
			if (!isset($categories[$key]->items)) {
				unset($categories[$key]);
			}
		}

		return $categories;
	}
}