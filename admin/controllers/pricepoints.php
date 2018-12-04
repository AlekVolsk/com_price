<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\AdminController;

class PriceControllerPricepoints extends AdminController
{
	function __construct($config = [])
	{
		parent::__construct($config);
	}

	public function getModel($name = 'Pricepoint', $prefix = 'PriceModel', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}
}