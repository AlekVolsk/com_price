<?php defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

JLoader::register('ModPriceHelper', __DIR__ . '/helper.php');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
$list = ModPriceHelper::getList($params);

$preText = trim($params->get('pretext', ''));
$postText = trim($params->get('posttext', ''));
$emptyText = trim($params->get('emptytext', ''));
if (!$emptyText) {
    $emptyText = Text::_('MOD_PRICE_EMPTYTEXT_DEFAULT');
}

require ModuleHelper::getLayoutPath('mod_price', $params->get('layout', 'default'));
