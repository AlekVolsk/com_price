<?php defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
$pretext = $this->params->get('pretext', '');
$posttext = $this->params->get('posttext', '');
?>

<div class="com_price">
    
    <h1><?php echo $this->title; ?></h1>
    
    <?php if ($pretext) { ?>
    <div class="pretext"><?php echo $pretext; ?></div>
    <?php } ?>
    
    <table class="uk-table">
        <thead>
            <tr>
                <th><?php echo Text::_('COM_PRICE_COLUMN_TITLE'); ?></th>
                <th><?php echo Text::_('COM_PRICE_COLUMN_VAL'); ?></th>
                <th><?php echo Text::_('COM_PRICE_COLUMN_UNIT'); ?></th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($this->items as $item) { ?>
            <tr id="cat-<?php echo $item->id; ?>">
                <td colspan="3"><?php echo '<h' . ($item->level + 3) . '>', $item->title, '</h' . ($item->level + 3) . '>'; ?></td>
            </tr>
            <?php
            if (isset($item->items)) {
                foreach ($item->items as $priceitem) {
            ?>
            <tr>
                <?php if ($priceitem->val > 0) { ?>
                <td><?php echo $priceitem->title; ?></td>
                <td><?php echo number_format($priceitem->val, 0, '', ' '); ?></td>
                <td><?php echo $priceitem->unit; ?></td>
                <?php  } else { ?>
                <td colspan="3"><?php echo $priceitem->title; ?></td>
                <?php  } ?>
            </tr>
            <?php
                    }
                }
            } ?>
        </tbody>
    </table>
    
    <?php if ($posttext) { ?>
    <div class="posttext"><?php echo $posttext; ?></div>
    <?php } ?>
    
</div>
