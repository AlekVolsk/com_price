<?php defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;

class PriceViewPriceitem extends HtmlView
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
		$this->title = Text::_('COM_PRICE_ITEM_TITLE_' . ($isNew ? 'ADD' : 'MOD'));

		\PriceHelper::getEnv('priceitem', true);

		$canDo = ContentHelper::getActions('com_price');
		if ($canDo->get('core.manage')) {
			ToolBarHelper::apply('priceitem.apply');
			ToolBarHelper::save('priceitem.save');
			ToolBarHelper::save2new('priceitem.save2new');
			ToolBarHelper::save2new('priceitem.save2copy');
		}
		if ($isNew) {
			ToolBarHelper::cancel('priceitem.cancel');
		} else {
			ToolBarHelper::cancel('priceitem.cancel', 'JTOOLBAR_CLOSE');
		}

		parent::display($tpl);
	}
}
