<?php defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;

class TablePrice_Pricepoints extends Table
{
	function __construct(&$db)
	{
		parent::__construct('#__pricelist_points', 'id', $db);
	}
}