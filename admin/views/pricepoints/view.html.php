<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;

class PriceViewPricepoints extends HtmlView
{
	public $items;
	public $pagination;
	public $state;
	public $title;
	protected $allCount;

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->allCount = $this->get('AllCount');
		if (count($errors = $this->get('Errors'))) {
			\JError::raiseError(500, implode('\n', $errors));
			return false;
		}

		\PriceHelper::getEnv('pricepoints');
		$this->sidebar = \JHtmlSidebar::render();
		$this->title = Text::_('COM_PRICE_PRICEPOINTS_SUBMENU');

		$canDo = ContentHelper::getActions('com_price');
		if ($canDo->get('core.manage')) {
			ToolBarHelper::addNew('pricepoint.add', 'COM_PRICE_LIST_TOOLBAR_ADD');
			if (count($this->items) > 0) {
				ToolBarHelper::editList('pricepoint.edit');
				ToolBarHelper::deleteList('COM_PRICE_DELETE_QUERY_STRING', 'pricepoints.delete', 'JTOOLBAR_DELETE');
			}
			$custom_button_html = '<button type="button" disabled="disabled" class="btn btn-small" style="opacity:1;"><span class="icon-database"></span>' . Text::sprintf('J_COUNT_ITEMS_VIEW', count($this->items), $this->allCount) . '</button>';
			ToolBar::getInstance('toolbar')->appendButton('Custom', $custom_button_html, 'options');
			if ($canDo->get('core.admin')) {
				ToolBarHelper::preferences('com_price');
			}
		}

		parent::display($tpl);
	}
}
