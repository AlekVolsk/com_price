<?php defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('list');

class JFormFieldUnit extends JFormFieldList
{

	public $type = 'unit';

	protected static $options = [];

	protected function getOptions()
	{
		$hash = md5($this->element);

		if (!isset(static::$options[$hash])) {
			static::$options[$hash] = parent::getOptions();
			$options = [];
			$db = Factory::getDbo();
			$query = $db->getQuery(true)
				->select('s.id as value, s.name as text')
				->from('#__pricelist_points as s')
				->order('s.id');
			$db->setQuery($query);

			if ($options = $db->loadObjectList()) {
				static::$options[$hash] = array_merge(static::$options[$hash], $options);
			}
		}

		return static::$options[$hash];
	}

}