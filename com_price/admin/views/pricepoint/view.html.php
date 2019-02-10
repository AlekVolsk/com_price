<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;

class PriceViewPricepoint extends HtmlView
{
	public $form;
	public $item;
	public $state;

	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		if (count($errors = $this->get('Errors'))) {
			\JError::raiseError(500, implode('\n', $errors));
			return false;
		}

		$isNew = $this->item->id == 0;
		$this->title = JText::_('COM_PRICE_POINT_TITLE_' . ($isNew ? 'ADD' : 'MOD'));

		\PriceHelper::getEnv('pricepoint', true);

		$canDo = ContentHelper::getActions('com_price');
		if ($canDo->get('core.manage')) {
			ToolBarHelper::apply('pricepoint.apply');
			ToolBarHelper::save('pricepoint.save');
			ToolBarHelper::save2new('pricepoint.save2new');
			ToolBarHelper::save2new('pricepoint.save2copy');
		}
		if ($isNew) {
			ToolBarHelper::cancel('pricepoint.cancel');
		} else {
			ToolBarHelper::cancel('pricepoint.cancel', 'JTOOLBAR_CLOSE');
		}

		parent::display($tpl);
	}
}
