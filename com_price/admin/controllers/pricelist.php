<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\AdminController;

class PriceControllerPricelist extends AdminController
{
	function __construct($config = [])
	{
		parent::__construct($config);
	}

	public function getModel($name = 'Priceitem', $prefix = 'PriceModel', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function saveOrderAjax()
	{
		$pks = $this->input->post->get('cid', [], 'array');
		$order = $this->input->post->get('order', [], 'array');
		\JArrayHelper::toInteger($pks);
		\JArrayHelper::toInteger($order);
		$model = $this->getModel();
		$return = $model->saveorder($pks, $order);
		if ($return) {
			echo '1';
		}
		Factory::getApplication()->close();
	}
}
