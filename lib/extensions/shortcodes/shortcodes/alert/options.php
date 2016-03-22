<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
		'text'         => array(
				'type'  => 'wp-editor',
				'label' => __( 'Text', 'fw' ),
				'desc'  => __( 'Add a short description, no more than 100 characters.', 'fw' ),
				'tinymce' => true,
				'reinit' => true,
		),
		'type' => array(
				'type'  => 'select',
				'value' => 'info',
				'label' => __('Type', 'fw'),
				'desc'  => __('Choose box type. The type determines the color and icon to be used.', 'fw'),
				'choices' => array(
						'info' => __('Information', 'fw'),
						'warning' => __('Warning', 'fw'),
						'danger' => __('Urgent', 'fw'),
						'success' => __('Positive', 'fw'),
				)
		)
);

//$options = array(
//	'text'         => array(
//		'type'  => 'wp-editor',
//		'label' => __( 'Text', 'fw' ),
//		'desc'  => __( 'Ange en kort informativ text på max 100 tecken.', 'fw' ),
//		'tinymce' => true,
//		'reinit' => true,
//	),
//	'type' => array(
//		'type'  => 'select',
//		'value' => 'info',
//		'label' => __('Typ', 'fw'),
//		'desc'  => __('Ange typ av ruta. Detta styr vilken färg och ikon som kommer användas.', 'fw'),
//		'choices' => array(
//			'info' => __('Information', 'fw'),
//			'warning' => __('Varning', 'fw'),
//			'danger' => __('Brådskande', 'fw'),
//			'success' => __('Positivt', 'fw'),
//		)
//	)
//);