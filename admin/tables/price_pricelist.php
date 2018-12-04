<?php defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;

class TablePrice_Pricelist extends Table
{
	function __construct(&$db)
	{
		parent::__construct('#__pricelist', 'id', $db);
	}
}