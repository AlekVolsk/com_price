<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

?>

<form action="<?php echo Route::_('index.php?option=com_price&view=pricepoints'); ?>" method="post" name="adminForm" id="adminForm">
	
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
		
			<table class="table table-striped" id="articleList">
				<thead>
					<tr>
						<th width="1%" class="hidden-phone center"><input class="hasTooltip" type="checkbox" name="checkall-toggle" value="" title="<?php echo Text::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" /></th>
						<th><?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'name', $listDirn, $listOrder); ?></th>
						<th width="1%" class="hidden-phone center nowrap"><?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($this->items as $i => $item) {
						$canEdit = Factory::getUser()->authorise('core.manage', 'com_price');
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="center hidden-phone">
							<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
						</td>
						<td class="has-context">
							<?php
							echo ($canEdit ? '<a href="' . Route::_('index.php?option=com_price&task=pricepoint.edit&id=' . $item->id) . '">' : '');
							echo $item->name;
							echo ($canEdit ? '</a>' : '');
							?>
						</td>
						<td class="center hidden-phone"><?php echo $item->id; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			
			<?php echo $this->pagination->getListFooter(); ?>
				
		<?php } ?>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo HTMLHelper::_('form.token'); ?>
		
	</div>
</form>