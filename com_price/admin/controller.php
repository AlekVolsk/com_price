<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

class PriceController extends BaseController
{
	function display($cachable = false, $urlparams = [])
	{
		$this->default_view = 'pricelist';
		parent::display($cachable, $urlparams);
		return $this;
	}
}
