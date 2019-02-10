<?php defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>

<div class="mod_price">
    
    <?php if (!empty($list)) { ?>
    
    <?php if ($preText) { ?>
    <div class="alert"><?php echo $preText; ?></div>
    <?php } ?>
    
    <table class="table">
        <thead>
            <tr>
                <th><?php echo Text::_('MOD_PRICE_NAME'); ?></th>
                <th><?php echo Text::_('MOD_PRICE_VALUE'); ?></th>
                <th><?php echo Text::_('MOD_PRICE_POINT'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($list as $item) {
                if (isset($item->items)) {
            ?>
            <tr>
                <td colspan="3">
                    <strong><?php echo $item->title; ?></strong>
                </td>
            </tr>
            <?php
                    foreach ($item->items as $priceitem) {
            ?>
            <tr>
                <?php if ($priceitem->val > 0) { ?>
                <td><?php echo $priceitem->title; ?></td>
                <td><?php echo number_format($priceitem->val, 2, '.', ' '); ?></td>
                <td><?php echo $priceitem->unit; ?></td>
                <?php } else { ?>
                <td colspan="3"><?php echo $priceitem->title; ?></td>
                <?php } ?>
            </tr>
            <?php } } } ?>
        </tbody>
    </table>
    
    <?php if ($postText) { ?>
    <div class="alert"><?php echo $postText; ?></div>
    <?php } ?>

    <?php } else { ?>
    <div class="alet alert-danger"><?php echo $emptyText; ?></div>
    <?php } ?>
</div>
