<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
} ?>

<?php if(!empty($atts['tabs'])): ?>
<div class="tabs">
	<ul class="tabs__titles" data-tabs role="tablist">
		<?php foreach($atts['tabs'] as $i => $tab): ?>

			<li data-tab class="tabs__title<?php echo $i == 0 ? ' is-active' : '' ?>" role="presentation"><a href="#tabPanel<?php echo $i ?>" role="tab" tabindex="0"<?php echo $i == 0 ? ' aria-selected="true"' : '' ?>aria-controls="tabPanel<?php echo $i ?>"><?php echo $tab['tab_title'] ?></a></li>

		<?php endforeach ?>
	</ul>

	<div class="tabs__panels" data-panels>

		<?php foreach($atts['tabs'] as $i => $tab): ?>
			<section role="tabpanel" aria-hidden="<?php echo $i == 0 ? 'false' : 'true' ?>" class="tabs__panel<?php echo $i == 0 ? ' is-active' : '' ?>" id="tabPanel<?php echo $i ?>">
				<?php echo $tab['tab_content'] ?>
			</section>
		<?php endforeach ?>

	</div>
</div>
<?php endif ?>