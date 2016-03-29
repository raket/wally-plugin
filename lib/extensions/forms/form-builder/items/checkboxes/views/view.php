<?php if (!defined('FW')) die('Forbidden');
/**
 * @var array $item
 * @var array $choices
 * @var array $value
 */

$options = $item['options'];
?>
<?php if (empty($choices)): ?>
    <!-- checkboxes not displayed: no choices -->
<?php else: ?>
    <div class="<?php echo esc_attr(fw_ext_builder_get_item_width('form-builder', $item['width'] .'/frontend_class')) ?>">
        <div class="field-checkbox input-styled">
            <fieldset class="custom-checkbox">
                <legend><?php echo fw_htmlspecialchars($item['options']['label']) ?>
                    <?php if ($options['required']): ?><sup>* (<?php _e('Required', 'fw');?>)</sup><?php endif; ?>
                </legend>
                <?php if ($options['info']): ?>
                    <p><em><?php echo $options['info'] ?></em></p>
                <?php endif; ?>
                <?php foreach ($choices as $choice): ?>
                    <?php $choice['id'] = 'rand-'. fw_unique_increment(); ?>
                    <div class="options">
                        <input <?php echo fw_attr_to_html($choice) ?> />
                        <label for="<?php echo esc_attr($choice['id']) ?>"><?php echo $choice['value'] ?></label>
                    </div>
                <?php endforeach; ?>
            </fieldset>
        </div>
    </div>
<?php endif; ?>