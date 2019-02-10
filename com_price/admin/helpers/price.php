<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;

class PriceHelper
{
	static function getEnv($vName, $hMenu = false)
	{
		ToolBarHelper::title(Text::_('COM_PRICE'), 'database');

		self::addSubmenu($vName);

		if ((bool)$hMenu) {
			Factory::getApplication()->input->set('hidemainmenu', true);
		}
	}

	static function addSubmenu($vName)
	{
		\JHtmlSidebar::addEntry(Text::_('COM_PRICE_PRICELIST_SUBMENU'), 'index.php?option=com_price&view=pricelist', $vName == 'pricelist');
		\JHtmlSidebar::addEntry(Text::_('COM_PRICE_CATEGORIES_SUBMENU'), 'index.php?option=com_categories&extension=com_price', $vName == 'categories');
		\JHtmlSidebar::addEntry(Text::_('COM_PRICE_PRICEPOINTS_SUBMENU'), 'index.php?option=com_price&view=pricepoints', $vName == 'pricepoints');
	}
}