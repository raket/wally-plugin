<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
} ?>

<div class="dropdown" data-dd>
	<button class="button button--small" aria-haspopup="true" data-dd-trigger><?php echo $atts['title'] ?> <i class="material-icons">keyboard_arrow_down</i></button>
	<div class="dropdown__drawer" data-dd-drawer>

		<?php if($atts['note']['display_note'] && $atts['note']['note']['text']): ?>
			<div class="dropdown__note">
				<i class="material-icons">info</i> <?php echo $atts['note']['note']['text'] ?>
			</div>
		<?php endif ?>

		<ul class="dropdown__list">
			<?php foreach($atts['alternatives'] as $alternative): ?>
			<li data-value="<?php echo $alternative['value'] ?>">
				<button type="button" class="button" data-value="<?php echo $alternative['value'] ?>">
					<?php echo $alternative['label'] ?>
				</button>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>
