<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'text' => array(
		'type'   => 'wp-editor',
		'teeny'  => true,
		'tinymce' => true,
		'reinit' => true,
		'label'  => __( 'Content', 'fw' ),
		'desc'   => __( 'Enter some content for this texblock', 'fw' )
	),
	'columns' => array(
		'type'  => 'select',
		'label' => __('Columns', 'fw'),
		'desc'  => __('Split text in columns for readability', 'fw'),
		'choices' => array(
			'' => __('1 Column', 'fw'),
			'two-col' => __('2 Column', 'fw'),
			'three-col' => __('3 Column', 'fw'),
		),
		/**
		 * Allow save not existing choices
		 * Useful when you use the select to populate it dynamically from js
		 */
		'no-validate' => false,
	)
);
