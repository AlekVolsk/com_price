<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Language\Text;

if (!Factory::getUser()->authorise('core.manage', 'com_price')) {
	return \JError::raiseWarning(403, Text::_('JERROR_ALERTNOAUTHOR'));
}

require_once JPATH_COMPONENT . '/helpers/price.php';

$controller = BaseController::getInstance('price');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
