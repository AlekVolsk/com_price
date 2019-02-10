<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Menu\SiteMenu;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;

class PriceViewPricelist extends HtmlView
{
	public $items;
	public $title;
	public $params;

	public function display($tpl = null)
	{
		try {
			$this->items = $this->get('Items');
			if (count($errors = $this->get('Errors'))) {
				\JError::raiseError(500, implode('\n', $errors));
				return false;
			}

			$this->params = $params = ComponentHelper::getParams('com_price');
			
			$menu = SiteMenu::getInstance('site')->getActive();
			$page_title = $menu->params->get('page_heading', '');
			$show_page_heading = $menu->params->get('show_page_heading');
			$this->title = $page_title && $show_page_heading ? $page_title : Text::_('COM_PRICE_TITLE');

			parent::display($tpl);
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}
}