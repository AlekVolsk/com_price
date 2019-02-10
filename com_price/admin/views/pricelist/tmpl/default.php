<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

$saveOrder = $listOrder == 'ordering';
if ($saveOrder) {
	HTMLHelper::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), 'index.php?option=com_price&task=pricelist.saveOrderAjax&tmpl=component');
}

Factory::getDocument()->addScriptDeclaration("
Joomla.orderTable = function () {
	var table = document.getElementById('sortTable');
	var direction = document.getElementById('directionTable');
	var order = table.options[table.selectedIndex].value;
	if (order != '" . $listOrder . "') {
		dirn = 'asc';
	} else {
		dirn = direction.options[direction.selectedIndex].value;
	}
	Joomla.tableOrdering(order, dirn, '');
}
}");

?>

<form action="<?php echo Route::_('index.php?option=com_price&view=pricelist'); ?>" method="post" name="adminForm" id="adminForm">
	
	<?php if (!empty($this->sidebar)) { ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php } else { ?>
	<div id="j-main-container">
	<?php } ?>
		
		<legend><?php echo $this->title; ?></legend>
		
		<?php if (!$this->allCount) { ?>
		<div class="alert alert-warning"><?php echo Text::_('COM_PRICE_DATA_EMPTY'); ?></div>
		<?php } else { ?>
		
		<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
		
		<?php if (!count($this->items)) { ?>
		<div class="alert alert-warning"><?php echo Text::_('COM_PRICE_DATA_EMPTY_FROM_FILTER'); ?></div>
		<?php } else { ?>
			
			<table class="table table-striped" id="articleList">
				<thead>
					<tr>
						<th width="1%" class="hidden-phone center" nowrap="nowrap" style="min-width:35px;"><?php echo HTMLHelper::_('searchtools.sort', '', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?></th>
						<th width="1%" class="hidden-phone center"><input class="hasTooltip" type="checkbox" name="checkall-toggle" value="" title="<?php echo Text::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" /></th>
						<th width="5%" class="center" style="min-width:85px;"><?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'published', $listDirn, $listOrder); ?></th>
						<th><?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'title', $listDirn, $listOrder); ?></th>
						<th width="5%" style="text-align:right;"><?php echo Text::_('COM_PRICE_LIST_COLUMN_VAL'); ?></th>
						<th width="1%"><?php echo Text::_('COM_PRICE_LIST_COLUMN_UNIT'); ?></th>
						<th width="1%" class="hidden-phone center nowrap"><?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($this->items as $i => $item) {
						$canEdit = Factory::getUser()->authorise('core.manage', 'com_price');
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="order nowrap center hidden-phone">
							<?php
							if ($canEdit) {
								$disableClassName = (!$saveOrder ? ' inactive tip-top' : '');
								$disabledLabel = (!$saveOrder ? Text::_('JORDERINGDISABLED') : '');
							?>
							<span class="hasTooltip sortable-handler<?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>" rel="tooltip"><i class="icon-menu"></i></span>
							<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
							<?php } else { ?>
							<span class="sortable-handler inactive"><i class="icon-menu"></i></span>
							<?php } ?>
						</td>
						<td class="center hidden-phone">
							<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
						</td>
						<td class="center">
		                    <?php if (!$item->published) { ?>
							<a class="btn btn-mini hasPopover" title="<?php echo Text::_('JSTATUS'); ?>" data-content="<?php echo Text::_('JTOOLBAR_PUBLISH'); ?>" data-placement="bottom" onclick="return listItemTask('cb<?php echo $i; ?>','pricelist.publish');" href="javascript:void(0);"><span class="icon-unpublish"></span></a>
							<?php } else { ?>
							<a class="btn btn-mini hasPopover active" title="<?php echo Text::_('JSTATUS'); ?>" data-content="<?php echo Text::_('JTOOLBAR_UNPUBLISH'); ?>" data-placement="bottom" onclick="return listItemTask('cb<?php echo $i; ?>','pricelist.unpublish');" href="javascript:void(0);"><span class="icon-publish"></span></a>
							<?php } ?>
						</td>
						<td class="has-context">
							<?php
							echo ($canEdit ? '<a href="' . Route::_('index.php?option=com_price&task=priceitem.edit&id=' . $item->id) . '">' : '');
							echo $this->escape($item->title);
							echo ($canEdit ? '</a>' : '');
							?>
							<span class="small">(<?php echo Text::_('JCATEGORY'), ': ', $this->escape($item->category_title); ?>)</span>
						</td>
						<td style="text-align:right;"><?php echo $this->escape(number_format($item->val, 2, '.', ' ')); ?></td>
						<td><?php echo $item->unit; ?></td>
						<td class="center hidden-phone"><?php echo $item->id; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			
			<?php echo $this->pagination->getListFooter(); ?>
				
		<?php } } ?>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo HTMLHelper::_('form.token'); ?>
		
	</div>
</form>