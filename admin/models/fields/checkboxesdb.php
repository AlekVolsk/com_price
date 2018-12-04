<?php defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('checkboxes');

class JFormFieldCheckboxesDB extends JFormFieldCheckboxes
{

	protected $type = 'checkboxesdb';

	protected function getOptions()
	{
		$options = [];
		$src = (string)$this->element['src'];
		if (!empty($src)) {
			$db = Factory::getDBO();
			$items = $db->setQuery($src)->loadObjectList();
			if (isset($items)) {
				foreach ($items as $i => $item) {
					$option = HTMLHelper::_('select.option', (string)$item->key, (string)$item->value, 'value', 'text', $this->disabled);
					$option->checked = in_array($item->value, (array)$this->value);
					$option->onclick = $this->onclick;
					$option->onchange = $this->onchange;
					$options[] = $option;
				}
			}
		}
		return $options;
	}

}