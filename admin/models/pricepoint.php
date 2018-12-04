<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;

class PriceModelPricepoint extends AdminModel
{
	public function getForm($data = [], $loadData = true)
	{
		$form = $this->loadForm('com_price.pricepoint', 'pricepoint', ['control' => 'jform', 'load_data' => $loadData]);
		if (empty($form)) {
			return false;
		}
		return $form;
	}

	public function getTable($type = 'price_pricepoints', $prefix = 'Table', $config = [])
	{
		return Table::getInstance($type, $prefix, $config);
	}

	protected function loadFormData()
	{
		$data = Factory::getApplication()->getUserState('com_price.edit.pricepoint.data', []);
		if (empty($data)) {
			$data = $this->getItem();
		}
		return $data;
	}

	protected function canDelete($record)
	{
		if (!empty($record->id)) {
			return Factory::getUser()->authorise('core.manage', 'com_price');
		}
	}

	protected function canEditState($record)
	{
		if (!empty($record->id) || !empty($record->catid)) {
			return Factory::getUser()->authorise('core.manage', 'com_price');
		} else {
			return parent::canEditState('com_price');
		}
	}

	protected function cleanCache($group = null, $client_id = 0)
	{
		parent::cleanCache('com_price');
	}
}
