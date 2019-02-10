<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;

class PriceModelPriceitem extends AdminModel
{
	public function getForm($data = [], $loadData = true)
	{
		$form = $this->loadForm('com_price.priceitem', 'priceitem', ['control' => 'jform', 'load_data' => $loadData]);
		if (empty($form)) {
			return false;
		}
		if (!Factory::getUser()->authorise('core.edit.state', 'com_price.priceitem.' . $this->getState('extdataedit.id'))) {
			$form->setFieldAttribute('published', 'disabled', 'true');
			$form->setFieldAttribute('published', 'filter', 'unset');
		}
		return $form;
	}

	public function getTable($type = 'price_pricelist', $prefix = 'Table', $config = [])
	{
		return Table::getInstance($type, $prefix, $config);
	}

	protected function loadFormData()
	{
		$data = Factory::getApplication()->getUserState('com_price.edit.priceitem.data', []);
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

	public function save($data)
	{
		if ($data['id'] == 0) {
			$data['ordering'] = (int)$this->getDbo()->setQuery('select count(*) from `#__pricelist`')->loadResult() + 1;
		}
		$data['belong'] = json_encode($data['belong']);
		$data['srv'] = json_encode($data['srv']);
		return parent::save($data);
	}

	protected function cleanCache($group = null, $client_id = 0)
	{
		parent::cleanCache('com_price');
	}
}
